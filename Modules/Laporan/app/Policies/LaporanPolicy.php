<?php

namespace Modules\Laporan\Policies;

use App\Models\User;
use Modules\Laporan\Models\Laporan;

class LaporanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view their own or admin can view all
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Laporan $laporan): bool
    {
        // Admin can view any laporan
        if ($user->role === 'admin') {
            return true;
        }

        // User can only view their own
        return $user->id === $laporan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any user can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Laporan $laporan): bool
    {
        // Only owner can edit if status is Pending
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $laporan->user_id && $laporan->status_tindakan === 'Pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Laporan $laporan): bool
    {
        // Admin can delete any laporan, user can only delete their own
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $laporan->user_id;
    }

    /**
     * Determine whether the user can update status (admin only).
     */
    public function updateStatus(User $user, Laporan $laporan): bool
    {
        // Only admin can update status
        return $user->role === 'admin';
    }
}
