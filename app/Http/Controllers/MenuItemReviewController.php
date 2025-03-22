<?php

namespace App\Http\Controllers;

use App\Data\MenuItemReviewData;
use App\Models\MenuItem;
use App\Models\MenuItemReview;
use Illuminate\Http\Request;

class MenuItemReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenuItem $menuItem)
    {
        return MenuItemReviewData::collect($menuItem->reviews()->with('user')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MenuItem $menu)
    {
        $data = $request->validate([
            'review_text' => 'required|string|min:3|max:255',
            'stars' => 'required|integer|min:1|max:5',
        ], [
            'review_text.required' => 'Please provide your review text.',
            'review_text.min' => 'Your review must be at least 10 characters long.',
            'review_text.max' => 'Your review cannot exceed 255 characters.',
            'stars.required' => 'Please select a star rating.',
            'stars.integer' => 'The star rating must be a number.',
            'stars.min' => 'The star rating must be at least 1.',
            'stars.max' => 'The star rating cannot exceed 5.',
        ]);

        $data['user_id'] = $request->user()->id;
        $menu->reviews()->create($data);
        return redirect(route('menus.show', ['slug' => $menu->slug]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
