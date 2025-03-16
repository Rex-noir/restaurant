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
/**
 *
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property bool $is_available
 * @property int|null $preparation_time
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Image|null $primary_image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MenuItemReview> $reviews
 * @property-read int|null $reviews_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\MenuItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder search(string|null $term = null, array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem wherePreparationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuItem withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @mixin \Eloquent
 */
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

    public function getRelationItems(int $limit = 4)
    {
        $query = $this::with(['tags'])->where('category_id', '=', $this->category_id)
            ->where('id', '!=', $this->id)
            ->withAvg('reviews', 'stars')
            ->where('is_available', true);

        $tags = $this->tags->pluck('id');


        if ($tags->isNotEmpty()) {
            $query->withAnyTags($tags);
        }

        return $query
            ->orderByDesc('reviews_avg_stars')
            ->limit($limit)
            ->get();
    }
}
