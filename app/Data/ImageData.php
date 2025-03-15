<?php

namespace App\Data;

use App\Data\Transformers\PublicUrlTransformer;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class ImageData extends Data
{
    public function __construct(
        #[WithTransformer(PublicUrlTransformer::class)]
        #[MapOutputName('url')]
        public string $path,
        public int $order,
    ) {
    }
}
