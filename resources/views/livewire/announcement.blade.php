<section class="w-full">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">{{ __('Announcements Management') }}</h1>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                {{ __('Manage all announcements') }}
            </p>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            {{ __('Add Announcement') }}
        </flux:button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6">
        <flux:input
            wire:model.live="search"
            type="text"
            placeholder="{{ __('Search by title...') }}"
            icon="magnifying-glass"
            clearable
        />
    </div>

    <!-- Announcements Table -->
    <div class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-neutral-700">
        <table class="w-full">
            <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <button
                            wire:click="sortBy('title')"
                            class="flex items-center gap-2 font-semibold text-neutral-900 dark:text-neutral-100"
                        >
                            {{ __('Title') }}
                            @if ($sortBy === 'title')
                                <span class="text-xs">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </button>
                    </th>
                    <!-- Author column removed -->
                    <th class="px-6 py-3 text-left">
                        <button
                            wire:click="sortBy('date')"
                            class="flex items-center gap-2 font-semibold text-neutral-900 dark:text-neutral-100"
                        >
                            {{ __('Date') }}
                            @if ($sortBy === 'date')
                                <span class="text-xs">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left font-semibold text-neutral-900 dark:text-neutral-100">
                        {{ __('Image') }}
                    </th>
                    <th class="px-6 py-3 text-right font-semibold text-neutral-900 dark:text-neutral-100">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($announcements as $item)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-6 py-4">
                            <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $item->title }}</span>
                        </td>
                        <!-- Author cell removed -->
                        <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $item->date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->image)
                                <img
                                    src="{{ Storage::url($item->image) }}"
                                    alt="{{ $item->title }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                />
                            @else
                                <div class="h-12 w-12 rounded-lg bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    size="sm"
                                    variant="subtle"
                                    wire:click="openEditModal({{ $item->id }})"
                                    icon="pencil"
                                >
                                    {{ __('Edit') }}
                                </flux:button>
                                <flux:button
                                    size="sm"
                                    variant="danger"
                                    wire:click="deleteAnnouncement({{ $item->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this announcement?') }}"
                                    icon="trash"
                                >
                                    {{ __('Delete') }}
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="mb-4 h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.773 1.753M5.007 7.307a1 1 0 011.415-.496l3.85 2.413a1 1 0 00.588 0l3.85-2.413a1 1 0 011.415.496M5 15a4 4 0 018 0v3.1M5 15a4 4 0 018 0v3.1" />
                                </svg>
                                <p class="text-neutral-600 dark:text-neutral-400">{{ __('No announcements found') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $announcements->links() }}
    </div>

    <!-- Modal -->
    <flux:modal name="announcement-modal" wire:ignore.self class="max-w-2xl">
        <form wire:submit="saveAnnouncement" class="space-y-6">
            <div>
                <flux:heading level="2">
                    @if ($isEditing)
                        {{ __('Edit Announcement') }}
                    @else
                        {{ __('Create New Announcement') }}
                    @endif
                </flux:heading>
            </div>

            <flux:input
                wire:model="title"
                :label="__('Title')"
                type="text"
                required
                autofocus
            />

            <!-- Author input removed -->

            <flux:input
                wire:model="date"
                :label="__('Date')"
                type="date"
                required
            />

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-neutral-900 dark:text-neutral-100 mb-3">
                    {{ __('Image') }}
                </label>
                
                <div class="space-y-4">
                    @if ($imagePreview)
                        <div class="relative">
                            <img
                                src="{{ is_string($imagePreview) ? Storage::url($imagePreview) : $imagePreview->temporaryUrl() }}"
                                alt="Preview"
                                class="h-40 w-full rounded-lg object-cover"
                            />
                            @if (!$isEditing || $image)
                                <button
                                    type="button"
                                    wire:click="$set('image', null); $set('imagePreview', null)"
                                    class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-neutral-50 dark:bg-neutral-900 border-neutral-300 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-6" />
                                </svg>
                                <p class="mb-2 text-sm text-neutral-600 dark:text-neutral-400">
                                    <span class="font-semibold">{{ __('Click to upload') }}</span> {{ __('or drag and drop') }}
                                </p>
                                <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                    {{ __('PNG, JPG, GIF up to 5MB (will be converted to WebP)') }}
                                </p>
                            </div>
                            <input
                                type="file"
                                wire:model="image"
                                accept="image/*"
                                class="hidden"
                            />
                        </label>
                    </div>

                    @if ($image)
                        <div class="text-sm text-green-600 dark:text-green-400">
                            ✓ {{ __('File selected') }}: {{ $image->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                @error('image')
                    <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-900/20">
                    <ul class="list-inside space-y-1 text-sm text-red-600 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex gap-3">
                <flux:button type="submit" variant="primary">
                    @if ($isEditing)
                        {{ __('Update Announcement') }}
                    @else
                        {{ __('Create Announcement') }}
                    @endif
                </flux:button>
                <flux:button type="button" variant="subtle" wire:click="closeModal">
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    @script
        <script>
            Livewire.on('openModal', () => {
                document.dispatchEvent(new CustomEvent('modal-show', { 
                    detail: { name: 'announcement-modal' } 
                }));
            });

            Livewire.on('closeModal', () => {
                document.dispatchEvent(new CustomEvent('modal-close', { 
                    detail: { name: 'announcement-modal' } 
                }));
            });

            Livewire.on('announcement-created', () => {
                $wire.dispatch('notify', { message: 'Announcement created successfully', type: 'success' });
            });

            Livewire.on('announcement-updated', () => {
                $wire.dispatch('notify', { message: 'Announcement updated successfully', type: 'success' });
            });

            Livewire.on('announcement-deleted', () => {
                $wire.dispatch('notify', { message: 'Announcement deleted successfully', type: 'success' });
            });
        </script>
    @endscript
</section>