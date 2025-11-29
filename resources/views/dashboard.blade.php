<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="{{ route('users.index') }}" class="group relative aspect-video overflow-hidden rounded-xl border border-neutral-200 transition-colors hover:border-blue-400 dark:border-neutral-700 dark:hover:border-blue-600">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors group-hover:bg-black/10 dark:group-hover:bg-black/30">
                    <div class="text-center">
                        <svg class="mx-auto mb-2 h-8 w-8 text-white opacity-0 transition-opacity group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-white opacity-0 transition-opacity group-hover:opacity-100">{{ __('Users Management') }}</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('news.index') }}" class="group relative aspect-video overflow-hidden rounded-xl border border-neutral-200 transition-colors hover:border-green-400 dark:border-neutral-700 dark:hover:border-green-600">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors group-hover:bg-black/10 dark:group-hover:bg-black/30">
                    <div class="text-center">
                        <svg class="mx-auto mb-2 h-8 w-8 text-white opacity-0 transition-opacity group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v4m6 0a2 2 0 01-2 2h-2.5a2 2 0 01-2-2m0-5a2 2 0 012-2h2.5a2 2 0 012 2m0 5v5a2 2 0 01-2 2H9.5a2 2 0 01-2-2v-5m0 0H4" />
                        </svg>
                        <p class="text-sm font-semibold text-white opacity-0 transition-opacity group-hover:opacity-100">{{ __('News Management') }}</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('announcements.index') }}" class="group relative aspect-video overflow-hidden rounded-xl border border-neutral-200 transition-colors hover:border-purple-400 dark:border-neutral-700 dark:hover:border-purple-600">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors group-hover:bg-black/10 dark:group-hover:bg-black/30">
                    <div class="text-center">
                        <svg class="mx-auto mb-2 h-8 w-8 text-white opacity-0 transition-opacity group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
                        </svg>
                        <p class="text-sm font-semibold text-white opacity-0 transition-opacity group-hover:opacity-100">{{ __('Announcements Management') }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
