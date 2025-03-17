<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/** @typescript */
class UserData extends Data
{
    public function __construct(
        public int|Optional $id,
        public string $name,
        public string $email,
    ) {
    }

    public static function fromModel(User $user)
    {
        return self::from(
            [
                ...$user->toArray(),
                'id' => Optional::create()
            ]
        );
    }
}
