<?php

declare(strict_types=1);

namespace Src\UserManagement\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use App\Models\AuditLog;

final class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $oldData = [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user->bio,
        ];

        $user->name = $validated['name'];
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = '/storage/' . $path;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Registrar en auditoría
        if (
            $user->hasPermission('manage_users') || $user->hasPermission('manage_categories') ||
            $user->hasPermission('manage_articles') || $user->hasPermission('manage_opinions') ||
            $user->hasPermission('manage_tags') || $user->role === 'admin'
        ) {
            AuditLog::log('update', $user, "Actualizó su perfil de usuario", [
                'old' => $oldData,
                'new' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'bio' => $user->bio,
                ]
            ]);
        }

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();
        $user->update([
            'password' => bcrypt($validated['password']),
        ]);

        // Registrar en auditoría
        if (
            $user->hasPermission('manage_users') || $user->hasPermission('manage_categories') ||
            $user->hasPermission('manage_articles') || $user->hasPermission('manage_opinions') ||
            $user->hasPermission('manage_tags') || $user->role === 'admin'
        ) {
            AuditLog::log('update', $user, "Cambió su contraseña");
        }

        return back()->with('status', 'password-updated');
    }
}
