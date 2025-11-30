<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;

class PublicNews extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'date';
    public $sortDirection = 'desc';

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
        return News::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                // ✅ Tidak ada "orWhere('author', ...)" → SUDAH AMAN
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);
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
     * Render the component.
     */
    public function render()
    {
        return view('livewire.public-news', [
            'news' => $this->news,
        ])->layout('components.layouts.guest');
    }
}