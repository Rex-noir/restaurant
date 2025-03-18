<?php

namespace App\Data;

use App\enums\GenderEnums;
use App\Models\UserProfile;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/** @typescript */
class UserProfileData extends Data
{
    public function __construct(
        public GenderEnums $gender,
        public string $phone,
        public ?string $dateOfBirth,
        public int|Optional $userId,
        public ?ImageData $profileImage
    ) {
    }

    public static function fromModel(UserProfile $model)
    {
        return self::from(
            [
                ...$model->toArray(),
                'userId' => Optional::create()
            ]
        );
    }
}
