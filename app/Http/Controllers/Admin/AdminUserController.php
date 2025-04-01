<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projet;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(20);
        foreach ($users as $user) {
            $user->projets = Projet::where('user_id', $user->id)->pluck('name');
            $user->contributions = Contribution::where('user_id', $user->id)->get();
            $user->projects_count = $user->projets->count();
            $user->contributions_count = $user->contributions->count();
            $user->projects_supported_count = $user->contributions->pluck('projet_id')->unique()->count();
            $user->total_amount = $user->contributions->where('type', 'financière')->sum('amount');
            $user->waiting_projects = Projet::where('user_id', $user->id)->where('status', 'en_attente')->pluck('name');
            $user->en_cours_projects = Projet::where('user_id', $user->id)->where('status', 'en_cours')->pluck('name');
            $user->finished_projects = Projet::where('user_id', $user->id)->where('status', 'terminé')->pluck('name');
            $user->rejected_projects = Projet::where('user_id', $user->id)->where('status', 'rejeté')->pluck('name');
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt(Str::random(32)),
        ]);

        $token = Password::createToken($user);
        $user->sendPasswordResetNotification($token);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé et email de réinitialisation envoyé');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
