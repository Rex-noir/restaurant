<?php

namespace Database\Seeders;

use Database\Factories\MenuItemOptionFactory;
use Database\Factories\MenuItemOptionValueFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItemOptionFactory::new()->has(MenuItemOptionValueFactory::new()->count(4))->create();
    }
}
