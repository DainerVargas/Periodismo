<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = 'user';
    public $permissions = [];

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->hasPermission('manage_users')) {
            abort(403);
        }
    }

    public function openModal()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'role', 'permissions']);
        $this->showModal = true;
    }

    // Available permissions
    public $availablePermissions = [
        'manage_users' => 'Gestionar Usuarios',
        'manage_categories' => 'Gestionar Categorías',
        'manage_articles' => 'Gestionar Noticias',
    ];

    public function render()
    {
        $users = User::where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->permissions = $user->permissions ?? [];
        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? 'NULL'),
            'role' => 'required|in:admin,editor,user',
            'permissions' => 'array'
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'permissions' => ($this->role === 'admin') ? [] : $this->permissions,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->userId) {
            User::findOrFail($this->userId)->update($data);
        } else {
            User::create($data);
        }

        $this->showModal = false;
        $this->dispatch('saved'); 
    }
    
    public function togglePermission($permission)
    {
        if (in_array($permission, $this->permissions)) {
            $this->permissions = array_diff($this->permissions, [$permission]);
        } else {
            $this->permissions[] = $permission;
        }
    }
}
