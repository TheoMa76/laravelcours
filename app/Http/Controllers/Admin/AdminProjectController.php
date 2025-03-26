<?php

namespace App\Http\Controllers\Admin;

use App\Models\Projet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get projects with every data related to it : user and contributions
        $projets = Projet::with('user', 'contributions')->get();
        return view('admin.projects.index', compact('projets'));
    }

    /**
     * Validate the project ( put status to en_cours) to validate project that user submitted
     */
    public function validateProject(Projet $projet){
        $projet->status = 'en_cours';
        $projet->save();
        return redirect()->route('admin.projects.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'goal' => 'required|numeric',
            'end_date' => 'required|date',
        ]);
        $projet = new Projet();
        $projet->name = $request->name;
        $projet->description = $request->description;
        $projet->status = $request->status;
        $projet->start_date = $request->start_date;
        $projet->goal = $request->goal;
        $projet->end_date = $request->end_date;
        $projet->save();
        return redirect()->route('admin.projects.index')->with('success', 'Projet ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Projet $projet)
    {
        return view('admin.projects.show', compact('projet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projet $projet)
    {
        return view('admin.projects.edit', compact('projet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projet $projet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'goal' => 'required|numeric',
            'end_date' => 'required|date',
        ]);
        $projet->name = $request->name;
        $projet->description = $request->description;
        $projet->status = $request->status;
        $projet->start_date = $request->start_date;
        $projet->goal = $request->goal;
        $projet->end_date = $request->end_date;
        $projet->save();
        return redirect()->route('admin.projects.index')->with('success', 'Projet modifié avec succès');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet)
    {
        $projet->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Projet supprimé avec succès');
    }
}
