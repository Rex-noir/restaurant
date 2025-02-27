<?php

namespace App\Data\Transformers;

use Illuminate\Support\Facades\Storage;
use Spatie\LaravelData\Transformers\Transformer;

class PublicUrlTransformer implements Transformer
{
    public function transform(\Spatie\LaravelData\Support\DataProperty $property, mixed $value, \Spatie\LaravelData\Support\Transformation\TransformationContext $context): mixed
    {
            return url(Storage::url($value));
    }
}
