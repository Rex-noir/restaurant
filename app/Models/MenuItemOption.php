<?php

namespace App\Models;

use App\enums\MenuOptionTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemOption extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'menu_item_id',
    ];

    public function casts(): array
    {
        return [
            'type' => MenuOptionTypesEnum::class
        ];
    }

    public function menu_item()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function values()
    {
        return $this->hasMany(MenuItemOptionValue::class);
    }
}
