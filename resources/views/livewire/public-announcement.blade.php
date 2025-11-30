<div class="min-h-screen bg-white dark:bg-neutral-900">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 dark:from-purple-900 dark:to-purple-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-white mb-2">{{ __('Announcements') }}</h1>
            <p class="text-purple-100">{{ __('Important announcements and updates') }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <flux:input
                        wire:model.live="search"
                        type="text"
                        placeholder="{{ __('Search announcements...') }}"
                        icon="magnifying-glass"
                        clearable />
                </div>
                <div class="flex gap-2">
                    <button
                        wire:click="sortBy('date')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $sortBy === 'date' ? 'bg-purple-600 text-white dark:bg-purple-700' : 'bg-neutral-200 text-neutral-900 dark:bg-neutral-700 dark:text-neutral-100 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                        {{ __('Latest') }}
                    </button>
                    <button
                        wire:click="sortBy('title')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $sortBy === 'title' ? 'bg-purple-600 text-white dark:bg-purple-700' : 'bg-neutral-200 text-neutral-900 dark:bg-neutral-700 dark:text-neutral-100 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                        {{ __('A-Z') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- F-Pattern Layout -->
        @if ($announcements->count() > 0)
        @php
        $announcementsArray = $announcements->items();
        $heroAnnouncement = $announcementsArray[0] ?? null;
        $featuredAnnouncements = array_slice($announcementsArray, 1, 2);
        $remainingAnnouncements = array_slice($announcementsArray, 3);
        @endphp

        <!-- Hero Announcement (Top Horizontal Bar) -->
        @if ($heroAnnouncement)
        <article class="group mb-8 overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 hover:shadow-2xl dark:hover:shadow-2xl transition-all duration-300 dark:hover:shadow-purple-900/30">
            <div class="grid md:grid-cols-2 gap-0">
                <!-- Hero Image -->
                <div class="relative overflow-hidden bg-neutral-200 dark:bg-neutral-700 aspect-[16/10] md:aspect-auto">
                    @if ($heroAnnouncement->image)
                    <img
                        src="{{ Storage::url($heroAnnouncement->image) }}"
                        alt="{{ $heroAnnouncement->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
                        </svg>
                    </div>
                    @endif
                    <!-- Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-purple-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                            {{ __('Important') }}
                        </span>
                    </div>
                </div>

                <!-- Hero Content -->
                <div class="p-8 md:p-10 flex flex-col justify-center">
                    <!-- Date only (author removed) -->
                    <div class="flex items-center gap-4 mb-4 text-sm text-neutral-500 dark:text-neutral-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $heroAnnouncement->date->format('M d, Y') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-4 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors leading-tight">
                        {{ $heroAnnouncement->title }}
                    </h2>

                    <!-- View Link -->
                    <a href="#" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-bold text-base group/link">
                        {{ __('View Full Announcement') }}
                        <svg class="w-5 h-5 ml-2 group-hover/link:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        @endif

        <!-- Featured Announcements (Second Horizontal Bar) -->
        @if (count($featuredAnnouncements) > 0)
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            @foreach ($featuredAnnouncements as $featured)
            <article class="group overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 dark:hover:shadow-purple-900/20">
                <!-- Image -->
                <div class="relative overflow-hidden bg-neutral-200 dark:bg-neutral-700 aspect-video">
                    @if ($featured->image)
                    <img
                        src="{{ Storage::url($featured->image) }}"
                        alt="{{ $featured->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Date only (author removed) -->
                    <div class="flex items-center justify-between mb-3 text-xs text-neutral-500 dark:text-neutral-400">
                        <span>{{ $featured->date->format('M d, Y') }}</span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4 line-clamp-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        {{ $featured->title }}
                    </h3>

                    <!-- View Link -->
                    <a href="#" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm group/link">
                        {{ __('View Details') }}
                        <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @endif

        <!-- Remaining Announcements (Vertical Left Column with Sidebar) -->
        @if (count($remainingAnnouncements) > 0)
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Announcement List -->
            <div class="lg:col-span-2 space-y-6">
                @foreach ($remainingAnnouncements as $announcement)
                <article class="group flex gap-5 p-5 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:shadow-md dark:hover:shadow-lg transition-all duration-300 dark:hover:shadow-purple-900/10 hover:border-purple-300 dark:hover:border-purple-700">
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0 w-32 h-32 overflow-hidden rounded-lg bg-neutral-200 dark:bg-neutral-700">
                        @if ($announcement->image)
                        <img
                            src="{{ Storage::url($announcement->image) }}"
                            alt="{{ $announcement->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <!-- Date only (author removed) -->
                        <div class="flex items-center gap-3 mb-2 text-xs text-neutral-500 dark:text-neutral-400">
                            <span>{{ $announcement->date->format('M d, Y') }}</span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-3 line-clamp-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                            {{ $announcement->title }}
                        </h3>

                        <!-- View Link -->
                        <a href="#" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm group/link">
                            {{ __('View Details') }}
                            <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <!-- Recent Announcements Widget -->
                    <div class="p-6 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-950 dark:to-purple-900 border border-purple-200 dark:border-purple-800">
                        <h3 class="text-lg font-bold text-purple-900 dark:text-purple-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Recent') }}
                        </h3>
                        <div class="space-y-3">
                            @foreach (array_slice($announcementsArray, 0, 5) as $index => $recent)
                            <div class="flex gap-3 items-start">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <a href="#" class="text-sm font-semibold text-purple-900 dark:text-purple-100 hover:text-purple-600 dark:hover:text-purple-400 line-clamp-2 transition-colors">
                                        {{ $recent->title }}
                                    </a>
                                    <p class="text-xs text-purple-700 dark:text-purple-300 mt-1">
                                        {{ $recent->date->format('M d') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Links Widget -->
                    <div class="p-6 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            {{ __('Quick Links') }}
                        </h3>
                        <div class="space-y-2">
                            @foreach (['All Announcements', 'Important', 'Events', 'Deadlines', 'Archive'] as $link)
                            <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 text-sm font-medium hover:bg-purple-600 hover:text-white dark:hover:bg-purple-600 transition-colors border border-neutral-300 dark:border-neutral-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                {{ __($link) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Pagination -->
        <div class="mt-12">
            {{ $announcements->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
            </svg>
            <p class="mt-4 text-neutral-600 dark:text-neutral-400">{{ __('No announcements found') }}</p>
        </div>
        @endif
    </div>
</div>