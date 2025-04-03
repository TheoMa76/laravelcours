<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function stats()
    {
        $userCount = User::count();
        $projectCount = Projet::count();
        $contributionCount = Contribution::count();
        $pendingProjects = Projet::where('status', 'en_attente')->count();
        
        $financialContributionsTotal = Contribution::where('contribution_type_id', '1')
            ->sum('amount') ?? 0;

        $isWeekly = request()->has('weeklyStats');
        $startDate = $isWeekly ? now()->startOfWeek() : now()->startOfMonth();
        
        $usersCreatedThisPeriod = User::where('created_at', '>=', $startDate)->count();
        $projectsCreatedThisPeriod = Projet::where('created_at', '>=', $startDate)->count();
        $contributionsCreatedThisPeriod = Contribution::where('created_at', '>=', $startDate)->count();

        $lastUser = User::latest()->first();
        $lastProject = Projet::latest()->first();
        $lastContribution = Contribution::latest()->first();

        $lastUserCreated = $lastUser ? $lastUser->created_at->diffForHumans() : 'Aucun utilisateur inscrit';
        $lastProjectCreated = $lastProject ? $lastProject->created_at->diffForHumans() : 'Aucun projet créé';
        $lastContributionCreated = $lastContribution ? $lastContribution->created_at->diffForHumans() : 'Aucune contribution';

        if ($isWeekly) {
            $labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            $usersData = $this->getWeeklyData(User::class);
            $projectsData = $this->getWeeklyData(Projet::class);
        } else {
            $labels = ['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'];
            $usersData = $this->getMonthlyData(User::class);
            $projectsData = $this->getMonthlyData(Projet::class);
        }
        
        $contributionsData = [
            Contribution::where('contribution_type_id', '1')->count(),
            Contribution::where('contribution_type_id', '2')->count(),
            Contribution::where('contribution_type_id', '3')->count()
        ];

        return view('admin.home', compact(
            'userCount', 'projectCount', 'contributionCount', 'pendingProjects',
            'usersCreatedThisPeriod', 'projectsCreatedThisPeriod', 'contributionsCreatedThisPeriod',
            'lastUserCreated', 'lastProjectCreated', 'lastContributionCreated',
            'labels', 'usersData', 'projectsData', 'contributionsData', 'isWeekly',
            'financialContributionsTotal' // Ajout de la nouvelle variable
        ));
    }

    /**
     * Récupère les données mensuelles pour un modèle donné
     */
    private function getMonthlyData($model)
    {
        $currentYear = now()->year;
        
        $data = $model::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        $monthlyData = array_fill(1, 12, 0);
        
        foreach ($data as $month => $count) {
            $monthlyData[$month] = $count;
        }
        
        return array_values($monthlyData);
    }

    /**
     * Récupère les données hebdomadaires pour un modèle donné
     */
    private function getWeeklyData($model)
    {
        $startOfWeek = now()->startOfWeek();
        $daysOfWeek = [];
        
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $daysOfWeek[$day->format('Y-m-d')] = 0;
        }
        
        $data = $model::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [
                $startOfWeek,
                now()->endOfWeek()
            ])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        foreach ($data as $date => $count) {
            if (array_key_exists($date, $daysOfWeek)) {
                $daysOfWeek[$date] = $count;
            }
        }
        
        return array_values($daysOfWeek);
    }
}