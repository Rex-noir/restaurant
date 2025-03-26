<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Observers\MenuItemObserver;
use App\traits\Searchable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Tags\HasTags;

#[ObservedBy(MenuItemObserver::class)]
class MenuItem extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemFactory> */
    use HasFactory, HasTags, Searchable;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'preparation_time',
        'slug'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => MoneyCast::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
        parent::boot();
    }

    public function reviews()
    {
        return $this->hasMany(MenuItemReview::class);
    }

    public function primary_image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->chaperone();
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->chaperone();
    }

    public function getRelatedMenuItems(int $limit = 4)
    {
        $tags = $this->tags->pluck('id'); // Get the tag IDs of the current menu item

        // Step 1: Try to find items that share at least one tag
        $taggedItems = self::with(['tags', 'primary_image'])
            ->where('id', '!=', $this->id) // Exclude the current menu item
            ->where('is_available', true)
            ->withAvg('reviews', 'stars')
            ->when($tags->isNotEmpty(), function ($query) use ($tags) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('id', $tags);
                })
                    ->orderByRaw("(SELECT COUNT(*) FROM taggables WHERE taggables.taggable_id = menu_items.id AND taggables.tag_id IN (".$tags->implode(',').")) DESC");
            })
            ->limit($limit)
            ->get();

        // Step 2: If no items were found with matching tags, fallback to category-based filtering
        if ($taggedItems->isEmpty()) {
            $taggedItems = self::with(['tags', 'primary_image'])
                ->where('id', '!=', $this->id)
                ->where('is_available', true)
                ->where('category_id', $this->category_id) // Fallback to same category
                ->withAvg('reviews', 'stars')
                ->orderByDesc('reviews_avg_stars') // Prioritize highly rated items
                ->limit($limit)
                ->get();
        }

        return $taggedItems;
    }

}
