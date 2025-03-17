<?php

namespace App\Data;

use App\Models\MenuItemReview;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

/** @typescript */
class MenuItemReviewData extends Data
{
    public function __construct(
        public int $user_id,
        #[RequiredIf('review_text', 'null')]
        public ?int $stars,
        #[RequiredIf('stars', 'null')]
        public ?string $review_text,
        #[WithoutValidation()]
        public Lazy|UserData $user,
    ) {
    }

    public static function fromModel(MenuItemReview $model)
    {
        return self::from([
            ...$model->toArray(),
            'user' => Lazy::whenLoaded('user', $model, fn () => UserData::from($model->user)),
        ]);
    }
}
