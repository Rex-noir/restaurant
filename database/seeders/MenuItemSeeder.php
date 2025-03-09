<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::createQuietly([
            'name' => 'Guacamole',
            'description' => 'A delicious burger with all the fixings.',
            'price' => 10.99,
            'image_path' => storage_path('app/public/images/menu-items/guacamole.webp'),
            'category_id' => 1,
            'preparation_time' => 10,
            'slug' => 'guacamole',
        ]);
    }
}
