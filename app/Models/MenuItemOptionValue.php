<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemOptionValue extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemOptionValueFactory> */
    use HasFactory;

    protected $fillable = [
        'menu_item_option_id',
        'value',
        'price_mod'
    ];

    public function option()
    {
        return $this->belongsTo(MenuItemOption::class);
    }
}
