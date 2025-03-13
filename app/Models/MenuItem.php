<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Observers\MenuItemObserver;
use App\traits\Searchable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'image_path',
        'is_available',
        'preparation_time',
        'slug'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => MoneyCast::class
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function (MenuItem $category) {
            if ($category->isDirty('image_path')) {
                $oldImage = $category->getOriginal('image_path');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });

        static::deleting(function (Category $category) {
            if ($category->image_path && Storage::disk('public')->exists($category->image_path)) {
                Storage::disk('public')->delete($category->image_path);
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(MenuItemReview::class);
    }

    public function getRelationItems(int $limit = 4)
    {
        $query = $this::where('category_id', '=', $this->category_id)
            ->where('id', '!=', $this->id)
            ->withAvg('reviews', 'stars')
            ->where('is_available', true);

        $tagIds = $this->tags()->pluck('id');

        if ($tagIds->isNotEmpty()) {
            $query->withAnyTags($tagIds);
        }

        return $query
            ->orderByDesc('reviews_avg_stars')
            ->limit($limit)
            ->get();
    }
}
