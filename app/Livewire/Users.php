<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $isEditing = false;
    public $userId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirmation = false;

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->resetPage();
    }

    /**
     * Get the users list.
     */
    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
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
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
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
     * Save user (create or update).
     */
    public function saveUser(): void
    {
        if ($this->isEditing) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    /**
     * Create a new user.
     */
    private function createUser(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        $this->dispatch('user-created');
        $this->closeModal();
        $this->resetPage();
    }

    /**
     * Update an existing user.
     */
    private function updateUser(): void
    {
        $user = User::findOrFail($this->userId);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ];

        if ($this->password) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $this->validate($rules);

        if ($this->password) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $this->dispatch('user-updated');
        $this->closeModal();
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id): void
    {
        User::findOrFail($id)->delete();
        $this->dispatch('user-deleted');
        $this->resetPage();
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
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->userId = null;
        $this->showPassword = false;
        $this->showPasswordConfirmation = false;
    }

    /**
     * Toggle password visibility.
     */
    public function togglePasswordVisibility(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    /**
     * Toggle password confirmation visibility.
     */
    public function togglePasswordConfirmationVisibility(): void
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.users', [
            'users' => $this->users,
        ]);
    }
}
