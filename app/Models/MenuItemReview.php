<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemReview extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemReviewFactory> */
    use HasFactory;

    protected $fillalble = [
        'menu_item_id',
        'user_id',
        'stars',
        'review_text'
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
