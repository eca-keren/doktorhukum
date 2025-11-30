<?php

namespace App\Livewire\Settings;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property \App\Models\User $user
 * @method void delete()
 */
class DeleteUserForm extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        tap($authUser, $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}
