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
        $categories =  Category::all();

        $menuItemsQuery = MenuItem::query();

        if ($request->query('category')) {
            $menuItemsQuery->whereRelation('category', 'name', '=', $request->query('category'));
        }

        $menuItems = $menuItemsQuery->paginate($request->query('per_page', 10));

        return inertia('Home/MenusPage', [
            'categories' => CategoryData::collect($categories),
            'menuItems' => MenuItemData::collect($menuItems, PaginatedDataCollection::class)->wrap('paginated_data'),
        ]);
    }
}
