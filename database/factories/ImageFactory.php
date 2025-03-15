<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Storage;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Storage::disk('public')->makeDirectory('images');

        $filename = Str::uuid().'.jpg';

        $file = UploadedFile::fake()->image($filename, 800, 600);
        $path = $file->storeAs('images', $filename, 'public');
        return [
            'path' => $path,
            'order' => $this->faker->numberBetween(1, 100)
        ];
    }
}
