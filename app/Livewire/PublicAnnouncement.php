<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;

class PublicAnnouncement extends Component
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
     * Get the announcements list.
     */
    public function getAnnouncementsProperty()
    {
        return Announcement::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
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
        return view('livewire.public-announcement', [
            'announcements' => $this->announcements,
        ])->layout('components.layouts.guest');
    }
}
