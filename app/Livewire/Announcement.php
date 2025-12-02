<?php

namespace App\Livewire;

use App\Models\Announcement as AnnouncementModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Announcement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $isEditing = false;
    public $announcementId = null;

    public $title = '';
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
     * Get the announcements list.
     */
    public function getAnnouncementsProperty()
    {
        return AnnouncementModel::query()
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
        $announcement = AnnouncementModel::findOrFail($id);
        $this->announcementId = $announcement->id;
        $this->title = $announcement->title;
        $this->date = $announcement->date->format('Y-m-d');
        $this->imagePreview = $announcement->image;
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
     * Save announcement (create or update).
     */
    public function saveAnnouncement(): void
    {
        if ($this->isEditing) {
            $this->updateAnnouncement();
        } else {
            $this->createAnnouncement();
        }
    }

    /**
     * Create a new announcement.
     */
    private function createAnnouncement(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'image' => ['required', 'image', 'max:5120'], // 5MB max
        ]);

        if ($this->image) {
            $validated['image'] = $this->convertToWebp($this->image);
        }

        AnnouncementModel::create($validated);

        $this->dispatch('announcement-created');
        $this->closeModal();
        $this->resetPage();
    }

    /**
     * Update an existing announcement.
     */
    private function updateAnnouncement(): void
    {
        $announcement = AnnouncementModel::findOrFail($this->announcementId);

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ];

        if ($this->image) {
            $rules['image'] = ['required', 'image', 'max:5120'];
        }

        $validated = $this->validate($rules);

        if ($this->image) {
            // Delete old image
            if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = $this->convertToWebp($this->image);
        }

        $announcement->update($validated);

        $this->dispatch('announcement-updated');
        $this->closeModal();
    }

    /**
     * Delete an announcement.
     */
    public function deleteAnnouncement($id): void
    {
        $announcement = AnnouncementModel::findOrFail($id);
        
        // Delete image
        if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
            Storage::disk('public')->delete($announcement->image);
        }
        
        $announcement->delete();
        $this->dispatch('announcement-deleted');
        $this->resetPage();
    }

    /**
     * Convert image to WebP format.
     */
    private function convertToWebp($image)
    {
        $filename = time() . '_' . uniqid() . '.webp';
        $path = 'announcements/' . $filename;

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory('announcements', 0755, true);

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
        $this->date = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->announcementId = null;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.announcement', [
            'announcements' => $this->announcements,
        ]);
    }
}
