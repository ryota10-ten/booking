<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $user = auth()->user();
        $restaurantId = $request->input('restaurant_id');

        if (!$user) {
            return redirect()->route('login.show');
        }

        if ($user->hasFavorited($restaurantId)) {
            $user->favorites()->detach($restaurantId);
        } else {
            $user->favorites()->attach($restaurantId);
        }

        return redirect()->back();
    }

}
