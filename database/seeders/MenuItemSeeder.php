<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::createQuietly([
            'name' => 'Guacamole',
            'description' => fake()->sentence(),
            'price' => 10.99,
            'category_id' => 1,
            'preparation_time' => 10,
            'slug' => 'guacamole',
        ]);
    }
}
