<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogManagement extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('action', 'like', "%{$this->search}%")
                    ->orWhere('model_type', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(20);

        return view('livewire.admin.audit-log-management', [
            'logs' => $logs
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
