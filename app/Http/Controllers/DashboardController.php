<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Projet;

class DashboardController extends Controller
{

    public function index()
    {
        $userProjects = Projet::where('user_id', auth()->id())->get();
        $userContributions = Contribution::where('user_id', auth()->id())->get();
        $userContributionsCount = Contribution::where('user_id', auth()->id())->count();
        $userContributionsTotal = Contribution::where('user_id', auth()->id())->sum('amount') ?? 0;

        return view('dashboard', compact(
            'userProjects',
            'userContributions',
            'userContributionsCount',
            'userContributionsTotal'
        ));
    }

  
}
