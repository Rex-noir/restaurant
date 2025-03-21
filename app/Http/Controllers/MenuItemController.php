<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Data\MenuItemData;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Spatie\LaravelData\PaginatedDataCollection;

class MenuItemController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();

        $menuItemsQuery = MenuItem::query()
            ->with(['tags', 'primary_image'])
            ->where('is_available', true)
            ->search(request()->query('search'), ['name', 'description', 'price', 'tags.name']);

        if ($request->query('category')) {
            $menuItemsQuery->whereRelation('category', 'name', '=', $request->query('category'));
        }

        $menuItems = $menuItemsQuery->paginate($request->query('per_page', 20));

        return inertia('Home/MenusPage', [
            'categories' => fn () => CategoryData::collect($categories),
            'menuItems' => MenuItemData::collect($menuItems, PaginatedDataCollection::class)
        ]);
    }

    public function show(string $slug)
    {
        $menu_item = MenuItem::with(['tags', 'primary_image', 'images'])->where('slug', $slug)->first();

        $related_items = $menu_item->getRelatedMenuItems();

        return inertia('Home/MenuItemPage', [
            'menu_item' => fn () => MenuItemData::from($menu_item),
            'related_items' => fn () => MenuItemData::collect($related_items)
        ]);
    }
}
