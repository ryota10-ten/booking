<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Restaurant;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function show()
    {
        $shops = Restaurant::with('area','genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('home',compact('shops','areas','genres'));
    }

    public function search(Request $request)
    {
        $shops = Restaurant::with('area','genre')
            ->AreaSearch($request->input('area_id'))
            ->GenreSearch($request->input('genre_id'))
            ->KeywordSearch($request->input('keyword'))
            ->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('home',compact('shops','areas','genres'));
    }
}