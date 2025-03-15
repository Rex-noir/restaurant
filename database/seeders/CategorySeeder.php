<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::factory(10)
            ->has(Image::factory()->count(1), 'image')
            ->has(MenuItem::factory()->count(2), 'menu_items')
            ->create();
    }
}
