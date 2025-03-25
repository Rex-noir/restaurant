<?php

namespace App\Http\Controllers;

use App\enums\GenderEnums;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/ProfileSetup');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['file', 'image', 'nullable'],
            'phone' => ['required', 'string', 'max:255'],
            'gender' => [Rule::enum(GenderEnums::class), 'required']
        ]);

        $user = auth()->user();

        $profile = $user->profile()->create($validated);

        if (isset($validated['image'])) {
            $image = $validated['image']->store('profile-images', 'public');
            if ($image) {
                $user->profile->profile_image()->updateOrCreate([
                    'path' => $image,
                ]);
            }
        }

        return redirect(route('profile.edit'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
