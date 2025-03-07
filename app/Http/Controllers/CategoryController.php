<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Data\MenuItemData;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Spatie\LaravelData\PaginatedDataCollection;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $menuItemsQuery = MenuItem::query()
            ->with('tags')
            ->search(['name', 'description', 'price', 'tags.name']);

        if ($request->query('category')) {
            $menuItemsQuery->whereRelation('category', 'name', '=', $request->query('category'));
        }

        $menuItems = $menuItemsQuery->paginate($request->query('per_page', 20));

        return inertia('Home/MenusPage', [
            'categories' => fn () => CategoryData::collect($categories),
            'menuItems' => MenuItemData::collect($menuItems, PaginatedDataCollection::class)
        ]);
    }
}
