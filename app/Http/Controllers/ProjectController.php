<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Projet;
use App\Models\Contribution;
use App\Models\MaterialCategory;
use App\Models\User;
use App\Models\ContributionType;
use App\Models\VolunteerRoleNeeded;
use App\Models\ProjectMaterialNeeded;

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
            'materials' => 'nullable|array',
            'materials.*.material_category_id' => 'required|exists:material_categories,id',
            'materials.*.description' => 'nullable|string',
            'roles' => 'nullable|array',
            'roles.*.name' => 'required|string|max:255',
            'roles.*.description' => 'nullable|string',
            'roles.*.volunteer_hours_needed' => 'required|numeric|min:0',
            'volunteer_hour_goal' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }
        $validated['status'] = 'en_attente';
        $validated['user_id'] = auth()->id();
        $project = Projet::create($validated);
    

        if (isset($request->materials)) {
            foreach ($request->materials as $material) {
                $project->projectMaterialNeeded()->create([
                    'material_category_id' => $material['material_category_id'],
                    'description' => $material['description'],
                ]);
            }
        }

        if (isset($request->roles)) {
            foreach ($request->roles as $role) {
                $project->volunteerRoleNeeded()->create([
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
        dd($request->all());
        $request->validate([
            'amount' => 'required|numeric',
            'donation_type' => 'required|string',
            'message' => 'nullable|string|max:255',
            'anonymous' => 'nullable|boolean',
            'materiels' => 'nullable|array',
            'custom_material' => 'nullable|string|max:255',
        ]);

        $contribution = new Contribution();
        $contributionType = ContributionType::where('name', $request->donation_type)->first();
        $contribution->contribution_type_id = $contributionType->id;
        $contribution->amount = $request->amount;
        $contribution->user_id = auth()->id();
        $contribution->projet_id = $id;
        if($request->donation_type == 'financial'){
            $contribution->aprouved_at = now();
            $contribution->description = $request->message;
        }else if($request->donation_type == 'material'){
            $contribution->type = 'matériel';
            $contribution->aprouved_at = null;
            $contribution->description = $request->custom_material;
        }else if($request->donation_type == 'volunteer'){
            $contribution->type = 'bénévolat';
            $contribution->aprouved_at = null;
            $contribution->description = $request->skills;
        }
        if($request->anonymous){
            $contribution->user_id = null;
        }else{
            $contribution->user_id = auth()->id();
        }
        $contribution->save();
        

        return redirect()->route('projets.show', $id)->with('success', 'Merci pour votre contribution !');
    }

    public function contributeForm($id){
        $projet = Projet::findOrFail($id);
        $projet->contributions = Contribution::where('projet_id', $id)->get();
        $projet->totalAmount = $projet->contributions->where('type','financière')->sum('amount');
        $projet->contributionCount = $projet->contributions->count();
        if($projet->contributionCount == 0){
            $projet->contributionCount = 1;
            $projet->amount = 0;
        }
        $materiels = ProjectMaterialNeeded::where('projet_id', $id)->with('materialCategory')->get();
        $roles = VolunteerRoleNeeded::where('projet_id', $id)->get();
        return view('projects.contribute', compact('projet','materiels', 'roles'));
    }
}
