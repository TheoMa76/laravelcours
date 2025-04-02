<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projet;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\HandleSorting;

class AdminUserController extends Controller
{
    use HandleSorting;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validSorts = ['id', 'name', 'email', 'created_at'];
        $relationSorts = ['projects_count', 'contributions_count'];

        $users = User::query();
        
        [$sort, $direction] = $this->applySorting($users, $validSorts, $relationSorts);

        $users = $users->paginate(20);

        foreach ($users as $user) {
            $user->projets = Projet::where('user_id', $user->id)->pluck('name');
            $user->contributions = Contribution::where('user_id', $user->id)->get();

            $user->projects_supported_count = $user->contributions->pluck('projet_id')->unique()->count();
            $user->contributions_count = $user->contributions->count();
            $user->projects_count = $user->projets->count();
            $user->total_amount = $user->contributions->where('type', 'financière')->sum('amount');
            $user->waiting_projects = $user->projets->where('status', 'en_attente')->pluck('name');
            $user->en_cours_projects = $user->projets->where('status', 'en_cours')->pluck('name');
            $user->finished_projects = $user->projets->where('status', 'terminé')->pluck('name');
            $user->rejected_projects = $user->projets->where('status', 'rejeté')->pluck('name');
        }

        $users->setCollection(
            $this->sortCollection($users->getCollection(), $sort, $direction, $relationSorts)
        );

        return view('admin.users.index', compact('users', 'sort', 'direction'));
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
