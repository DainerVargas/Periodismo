<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public $currentTab = 'users';

    public function mount($tab = null)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) return;

        if ($tab) {
            $this->currentTab = $tab;
            return;
        }

        // Determinar pestaña inicial de forma segura según permisos
        if ($user->hasPermission('manage_users')) {
            $this->currentTab = 'users';
        } elseif ($user->hasPermission('manage_categories')) {
            $this->currentTab = 'categories';
        } elseif ($user->hasPermission('manage_articles')) {
            $this->currentTab = 'articles';
        } elseif ($user->hasPermission('manage_opinions')) {
            $this->currentTab = 'opinions';
        } elseif ($user->hasPermission('manage_tags')) {
            $this->currentTab = 'tags';
        } elseif ($user->role === 'admin') {
            $this->currentTab = 'job_categories';
        } else {
            $this->currentTab = 'roles';
        }
    }

    /**
     * Gestiona el cambio de pestañas de forma reactiva
     */
    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
