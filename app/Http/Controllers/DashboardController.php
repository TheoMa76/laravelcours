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
        //user contrib
        $userContributions = Contribution::where('user_id', auth()->id())->get();
        foreach($userContributions as $contrib){
            $projetId = $contrib->projet_id;
            $projet = Projet::find($projetId);
            $contrib->projet_name = $projet->name;
        }
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
