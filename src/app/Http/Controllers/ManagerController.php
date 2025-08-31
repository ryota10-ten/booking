<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Booking;
use App\Models\Genre;
use App\Models\Restaurant;
use App\Http\Requests\AddShopRequest;
use App\Http\Requests\ManagerLoginRequest;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function manager_login(ManagerLoginRequest $request)
    {
        Auth::guard('managers')->attempt($request->only('email', 'password'));

        return redirect()->route('manager_page.show');
    }

    public function manager_login_show()
    {
        return view('manager.login');
    }

    public function manager_mypage()
    {
        $manager = Auth::guard('managers')->user();
        $restaurantIds = $manager->restaurants()->pluck('id');
        $bookings = Booking::with(['restaurant', 'user'])
            ->whereIn('restaurant_id', $restaurantIds)
            ->orderBy('book_at', 'desc')
            ->get();

        return view('manager.mypage',compact('bookings','manager'));
    }

    public function logout()
    {
        Auth::guard('managers')->logout();

        return redirect()->route('home');
    }

    public function shop_all_show()
    {
        $manager = Auth::guard('managers')->user();
        $managerId = $manager->id;
        $shops = Restaurant::where('manager_id', $managerId)
            ->with('area','genre')
            ->get();

        return view('manager.shop',compact('shops'));
    }

    public function shop_add_show()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view ('manager.add',compact('areas','genres'));
    }

    public function store(AddShopRequest $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('img', 'public');
        }

        Restaurant::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'detail' => $request->detail,
            'img_url' => $path,
            'manager_id' => Auth::guard('managers')->id(),
        ]);

        return redirect()->route('shop_all_show');
    }

    public function shop_edit_show($id)
    {
        $shop = Restaurant::with('area','genre')->find($id);
        $areas = Area::all();
        $genres = Genre::all();
        return view ('manager.edit',compact('shop','areas','genres'));
    }

    public function update(UpdateShopRequest $request,$id)
    {
        $shop = Restaurant::findOrFail($id);
        $shop->name     = $request->name;
        $shop->area_id  = $request->area_id;
        $shop->genre_id = $request->genre_id;
        $shop->detail   = $request->detail;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shops', 'public');
            $shop->img_url = $path;
        }

        $shop->save();
        return redirect()->route('shop_all_show');
    }
}
