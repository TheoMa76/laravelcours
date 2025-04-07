<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        //get the top 5 projects with the most contributions
        $projets = Projet::withCount('contributions')
            ->orderBy('contributions_count', 'desc')
            ->take(5)
            ->get();
        return view('welcome',compact('projets'));
    }
}
