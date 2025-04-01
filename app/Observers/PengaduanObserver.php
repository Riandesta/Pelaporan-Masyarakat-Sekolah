<?php

namespace App\Observers;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanObserver
{
    /**
     * Handle the Pengaduan "created" event.
     */
    public function created(Pengaduan $pengaduan): void
    {
        //
    }

    /**
     * Handle the Pengaduan "creating" event.
     */
    public function creating(Pengaduan $pengaduan): void
    {
        // Set user_id berdasarkan pengguna yang sedang login
        if (Auth::check()) {    
            $pengaduan->user_id = Auth::id();
        }
    }

    /**
     * Handle the Pengaduan "updated" event.
     */
    public function updated(Pengaduan $pengaduan): void
    {
        //
    }

    /**
     * Handle the Pengaduan "deleted" event.
     */
    public function deleted(Pengaduan $pengaduan): void
    {
        //
    }

    /**
     * Handle the Pengaduan "restored" event.
     */
    public function restored(Pengaduan $pengaduan): void
    {
        //
    }

    /**
     * Handle the Pengaduan "force deleted" event.
     */
    public function forceDeleted(Pengaduan $pengaduan): void
    {
        //
    }
}
