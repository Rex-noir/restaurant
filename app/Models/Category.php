<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'image_path'];

    public function menu_items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->chaperone();
    }

}
