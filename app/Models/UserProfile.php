<?php

namespace App\Models;

use App\enums\GenderEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'date_of_birth',
        'gender',
        'phone',
        'user_id'
    ];

    protected $casts = [
        'gender' => GenderEnums::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
