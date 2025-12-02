<?php

namespace App\Livewire;

use App\Models\News as NewsModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class News extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $isEditing = false;
    public $newsId = null;

    public $title = '';
    public $description = '';
    public $date = '';
    public $image = null;
    public $imagePreview = null;

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->resetPage();
    }

    /**
     * Get the news list.
     */
    public function getNewsProperty()
    {
        return NewsModel::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    /**
     * Open create modal.
     */
    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
        $this->dispatch('openModal');
    }

    /**
     * Open edit modal.
     */
    public function openEditModal($id): void
    {
        $news = NewsModel::findOrFail($id);
        $this->newsId = $news->id;
        $this->title = $news->title;
        $this->description = $news->description;
        $this->date = $news->date->format('Y-m-d');
        $this->imagePreview = $news->image;
        $this->image = null;
        $this->isEditing = true;
        $this->showModal = true;
        $this->dispatch('openModal');
    }

    /**
     * Close modal.
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('closeModal');
    }

    /**
     * Save news (create or update).
     */
    public function saveNews(): void
    {
        if ($this->isEditing) {
            $this->updateNews();
        } else {
            $this->createNews();
        }
    }

    /**
     * Create a new news.
     */
    private function createNews(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'date' => ['required', 'date'],
            'image' => ['required', 'image', 'max:5120'], // 5MB max
        ]);

        if ($this->image) {
            $validated['image'] = $this->convertToWebp($this->image);
        }

        NewsModel::create($validated);

        $this->dispatch('news-created');
        $this->closeModal();
        $this->resetPage();
    }

    /**
     * Update an existing news.
     */
    private function updateNews(): void
    {
        $news = NewsModel::findOrFail($this->newsId);

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'date' => ['required', 'date'],
        ];

        if ($this->image) {
            $rules['image'] = ['required', 'image', 'max:5120'];
        }

        $validated = $this->validate($rules);

        if ($this->image) {
            // Delete old image
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $this->convertToWebp($this->image);
        }

        $news->update($validated);

        $this->dispatch('news-updated');
        $this->closeModal();
    }

    /**
     * Delete a news.
     */
    public function deleteNews($id): void
    {
        $news = NewsModel::findOrFail($id);
        
        // Delete image
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();
        $this->dispatch('news-deleted');
        $this->resetPage();
    }

    /**
     * Convert image to WebP format.
     */
    private function convertToWebp($image)
    {
        $filename = time() . '_' . uniqid() . '.webp';
        $path = 'news/' . $filename;

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory('news', 0755, true);

        try {
            // Get the uploaded file path
            $imagePath = $image->getRealPath();
            $mimeType = $image->getMimeType();

            // Suppress warnings from GD library
            set_error_handler(function() {});

            // Create image based on mime type (suppress warnings)
            if (in_array($mimeType, ['image/jpeg', 'image/jpg'])) {
                $img = @imagecreatefromjpeg($imagePath);
            } elseif ($mimeType === 'image/png') {
                $img = @imagecreatefrompng($imagePath);
            } elseif ($mimeType === 'image/gif') {
                $img = @imagecreatefromgif($imagePath);
            } elseif ($mimeType === 'image/webp') {
                $img = @imagecreatefromwebp($imagePath);
            } else {
                restore_error_handler();
                throw new \Exception('Unsupported image format');
            }

            restore_error_handler();

            if ($img === false) {
                throw new \Exception('Failed to create image from uploaded file');
            }

            // Save as WebP
            $fullPath = Storage::disk('public')->path($path);
            @imagewebp($img, $fullPath, 80);
            imagedestroy($img);

            return $path;
        } catch (\Exception $e) {
            throw new \Exception('Image conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Sort by column.
     */
    public function sortBy($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Reset form fields.
     */
    private function resetForm(): void
    {
        $this->title = '';
        $this->description = '';
        $this->date = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->newsId = null;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.news', [
            'news' => $this->news,
        ]);
    }
}
