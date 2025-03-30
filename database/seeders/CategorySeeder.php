<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\MenuItem;
use App\Models\MenuItemOption;
use App\Models\MenuItemOptionValue;
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
            ->has(MenuItem::factory()->has(MenuItemOption::factory()->count(3)->has(MenuItemOptionValue::factory()->count(3), 'values'), 'options')->count(2), 'menu_items')
            ->create();
    }
}
