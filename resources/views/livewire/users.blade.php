<section class="w-full">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">{{ __('Users Management') }}</h1>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                {{ __('Manage all users in your system') }}
            </p>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            {{ __('Add User') }}
        </flux:button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6">
        <flux:input
            wire:model.live="search"
            type="text"
            placeholder="{{ __('Search by name or email...') }}"
            icon="magnifying-glass"
            clearable
        />
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-neutral-700">
        <table class="w-full">
            <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <button
                            wire:click="sortBy('name')"
                            class="flex items-center gap-2 font-semibold text-neutral-900 dark:text-neutral-100"
                        >
                            {{ __('Name') }}
                            @if ($sortBy === 'name')
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
                    <th class="px-6 py-3 text-left">
                        <button
                            wire:click="sortBy('email')"
                            class="flex items-center gap-2 font-semibold text-neutral-900 dark:text-neutral-100"
                        >
                            {{ __('Email') }}
                            @if ($sortBy === 'email')
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
                    <th class="px-6 py-3 text-left">
                        <button
                            wire:click="sortBy('created_at')"
                            class="flex items-center gap-2 font-semibold text-neutral-900 dark:text-neutral-100"
                        >
                            {{ __('Created') }}
                            @if ($sortBy === 'created_at')
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
                    <th class="px-6 py-3 text-right font-semibold text-neutral-900 dark:text-neutral-100">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                        {{ $user->initials() }}
                                    </span>
                                </div>
                                <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-neutral-600 dark:text-neutral-400">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    size="sm"
                                    variant="subtle"
                                    wire:click="openEditModal({{ $user->id }})"
                                    icon="pencil"
                                >
                                    {{ __('Edit') }}
                                </flux:button>
                                <flux:button
                                    size="sm"
                                    variant="danger"
                                    wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this user?') }}"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-neutral-600 dark:text-neutral-400">{{ __('No users found') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    <flux:modal name="user-modal" wire:ignore.self class="max-w-2xl">
        <form wire:submit="saveUser" class="space-y-6">
            <div>
                <flux:heading level="2">
                    @if ($isEditing)
                        {{ __('Edit User') }}
                    @else
                        {{ __('Create New User') }}
                    @endif
                </flux:heading>
            </div>

            <flux:input
                wire:model="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
            />

            <flux:input
                wire:model="email"
                :label="__('Email')"
                type="email"
                required
                autocomplete="email"
            />

            @if (!$isEditing)
                <div class="relative">
                    <flux:input
                        wire:model="password"
                        :label="__('Password')"
                        :type="$showPassword ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        wire:click="togglePasswordVisibility"
                        class="absolute right-3 top-9 text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200"
                    >
                        @if ($showPassword)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        @endif
                    </button>
                </div>

                <div class="relative">
                    <flux:input
                        wire:model="password_confirmation"
                        :label="__('Confirm Password')"
                        :type="$showPasswordConfirmation ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        wire:click="togglePasswordConfirmationVisibility"
                        class="absolute right-3 top-9 text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200"
                    >
                        @if ($showPasswordConfirmation)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        @endif
                    </button>
                </div>
            @else
                <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        {{ __('Leave password fields empty to keep the current password') }}
                    </p>
                </div>

                <div class="relative">
                    <flux:input
                        wire:model="password"
                        :label="__('New Password (Optional)')"
                        :type="$showPassword ? 'text' : 'password'"
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        wire:click="togglePasswordVisibility"
                        class="absolute right-3 top-9 text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200"
                    >
                        @if ($showPassword)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        @endif
                    </button>
                </div>

                @if ($password)
                    <div class="relative">
                        <flux:input
                            wire:model="password_confirmation"
                            :label="__('Confirm New Password')"
                            :type="$showPasswordConfirmation ? 'text' : 'password'"
                            required
                            autocomplete="new-password"
                        />
                        <button
                            type="button"
                            wire:click="togglePasswordConfirmationVisibility"
                            class="absolute right-3 top-9 text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200"
                        >
                            @if ($showPasswordConfirmation)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            @endif
                        </button>
                    </div>
                @endif
            @endif

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
                        {{ __('Update User') }}
                    @else
                        {{ __('Create User') }}
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
                    detail: { name: 'user-modal' } 
                }));
            });

            Livewire.on('closeModal', () => {
                document.dispatchEvent(new CustomEvent('modal-close', { 
                    detail: { name: 'user-modal' } 
                }));
            });

            Livewire.on('user-created', () => {
                $wire.dispatch('notify', { message: 'User created successfully', type: 'success' });
            });

            Livewire.on('user-updated', () => {
                $wire.dispatch('notify', { message: 'User updated successfully', type: 'success' });
            });

            Livewire.on('user-deleted', () => {
                $wire.dispatch('notify', { message: 'User deleted successfully', type: 'success' });
            });
        </script>
    @endscript
</section>
