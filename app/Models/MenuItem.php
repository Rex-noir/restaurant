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
    }

    public function reviews()
    {
        return $this->hasMany(MenuItemReview::class);
    }

    public function primary_image()
    {
        return $this->morphOne(Image::class, 'imageable')->chaperone();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->chaperone();
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
