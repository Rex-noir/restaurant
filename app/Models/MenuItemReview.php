<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $menu_item_id
 * @property int $user_id
 * @property int|null $stars
 * @property string|null $review_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MenuItem $menuItem
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\MenuItemReviewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereReviewText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItemReview whereUserId($value)
 * @mixin \Eloquent
 */
class MenuItemReview extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemReviewFactory> */
    use HasFactory;

    protected $fillable = [
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
