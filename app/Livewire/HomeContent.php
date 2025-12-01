<?php

namespace App\Livewire;

use App\Models\News;
use App\Models\Announcement;
use Livewire\Component;

class HomeContent extends Component
{
    public $latestNews = [];
    public $latestAnnouncements = [];

    public function mount()
    {
        // Ambil 3 berita terbaru
        $this->latestNews = News::orderBy('date', 'desc')->take(3)->get();

        // Ambil 4 pengumuman terbaru
        $this->latestAnnouncements = Announcement::orderBy('date', 'desc')->take(4)->get();
    }

    public function render()
    {
        return view('livewire.home-content');
    }
}