<?php

namespace App\Observers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * Handle the Image "updating" event.
     */
    public function updating(Image $image): void
    {
        if ($image->isDirty('path')) {
            $oldPath = $image->getOriginal('path');
            if ($oldPath && Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }
    }

    /**
     * Handle the Image "deleting" event.
     */
    public function deleting(Image $image): void
    {
        if ($image->path && Storage::exists($image->path)) {
            Storage::delete($image->path);
        }
    }

    /**
     * Handle the Image "restored" event.
     */
    public function restored(Image $image): void
    {
        // Handle restoring logic if necessary
    }

    /**
     * Handle the Image "force deleted" event.
     */
    public function forceDeleted(Image $image): void
    {
        if ($image->path && Storage::exists($image->path)) {
            Storage::delete($image->path);
        }
    }
}
