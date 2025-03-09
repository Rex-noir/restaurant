<?php

namespace Database\Seeders;

use App\Models\MenuItemReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItemReview::factory()->count(3)->create();
    }
}
