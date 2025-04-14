<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Projet;
use App\Models\Contribution;
use App\Models\MaterialCategory;
use App\Models\User;

class ProjectController extends Controller
{

    public function index()
    {
        $projets = Projet::with('user')->where('status', 'en_cours')->get();
        return view('projects.projets', compact('projets'));
    }

    public function create(){
        $edit = false;
        $material_categories = MaterialCategory::all();
        return view('projects.create', compact('edit','material_categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'money_goal' => 'required|numeric|min:0',
            'volunteer_hour_goal' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        dd($validated['image']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('project_images', 'public');
            $validated['image'] = $imagePath;
        }
        $validated['status'] = 'en_attente';
        $validated['user_id'] = auth()->id();
        $project = Projet::create($validated);
    

        if ($request->needsMaterials && $request->materials) {
            foreach ($request->materials as $material) {
                $project->materials()->create([
                    'material_category_id' => $material['material_category_id'],
                    'additional' => $material['additional'] ?? null,
                ]);
            }
        }

        if ($request->needsVolunteers && $request->roles) {
            foreach ($request->roles as $role) {
                $project->volunteerRoles()->create([
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'volunteer_hours_needed' => $role['volunteer_hours_needed'],
                ]);
            }
        }

        return redirect()->route('projets')->with('success', 'Projet créé avec succès!');
    }
    public function show($id){
        $projet = Projet::findOrFail($id);
        return view('projects.contribute', compact('projet'));
    }

    public function edit($id){
        $projet = Projet::findOrFail($id);
        $edit = true;
        return view('projects.create', compact('projet', 'edit'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'goal' => 'required|numeric',
            'end_date' => 'required|date',
        ]);

        $projet = Projet::findOrFail($id);
        $projet->name = $request->name;
        $projet->description = $request->description;
        $projet->status = $request->status;
        $projet->start_date = $request->start_date;
        $projet->goal = $request->goal;
        $projet->end_date = $request->end_date;
        $projet->save();

        return redirect()->route('projets')->with('success', 'Projet modifié avec succès');
    }

    public function destroy($id){
        $projet = Projet::findOrFail($id);
        if($projet->user_id != auth()->id() && !auth()->user()->isAdmin()){
            return redirect()->route('projets')->with('error', 'Vous n\'êtes pas autorisé à supprimer ce projet');
        }else{
            $projet->delete();

            return redirect()->route('projets')->with('success', 'Projet supprimé avec succès');
        }
    }

    public function contribute(Request $request, $id){
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $contribution = new Contribution();
        $contribution->amount = $request->amount;
        $contribution->user_id = auth()->id();
        $contribution->projet_id = $id;
        $contribution->save();

        return redirect()->route('projets.show', $id)->with('success', 'Merci pour votre contribution !');
    }

    public function contributeForm($id){
        $projet = Projet::findOrFail($id);
        $projet = Projet::findOrFail($id);
        $projet->contributions = Contribution::where('projet_id', $id)->get();
        $projet->totalAmount = $projet->contributions->where('type','financière')->sum('amount');
        $projet->contributionCount = $projet->contributions->count();
        if($projet->contributionCount == 0){
            $projet->contributionCount = 1;
            $projet->amount = 0;
        }
        return view('projects.contribute', compact('projet'));
    }
}
