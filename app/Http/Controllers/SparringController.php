<?php

namespace App\Http\Controllers;

use App\Models\Sparring;
use Illuminate\Http\Request;

class SparringController extends Controller
{
    public function index()
    {
        $sparrings = Sparring::orderBy('datetime')->get();
        
        return view('sparring.sparring', compact('sparrings'));
    }

    public function search(Request $request)
    {
        $query = Sparring::query();

        if ($request->has('search')) {
            $query->where('team_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('sport')) {
            $query->where('sport_type', 'like', '%' . $request->sport . '%');
        }

        $sparrings = $query->orderBy('datetime')->get();

        return view('sparring.index', compact('sparrings'));
    }
}