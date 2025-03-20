<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Projet;
use App\Models\Contribution;
use App\Models\User;

class ProjectController extends Controller
{

    public function index()
    {
        $projets = Projet::with('user')->get();
        return view('projects.projets', compact('projets'));
    }

    public function create(){
        return view('projects.create');
    }

    public function store(Request $request){
        \Log::info('Début de la méthode store');
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'goal' => 'required|numeric',
            'end_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
    
        // Création du projet
        $projet = new Projet();
        $projet->name = $validatedData['name'];
        $projet->description = $validatedData['description'];
        $projet->status = $validatedData['status'];
        $projet->start_date = $validatedData['start_date'];
        $projet->goal = $validatedData['goal'];
        $projet->end_date = $validatedData['end_date'];
        $projet->user_id = auth()->id();
    
        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $extension;
            $image->move(public_path('images'), $imageName);
            $projet->image = $imageName;
        } else {
            \Log::info('Aucun fichier image reçu.');
        }
    
        \Log::info('Projet avant sauvegarde : ', $projet->toArray());
    
        $projet->save();
    
        \Log::info('Projet sauvegardé avec succès');
    
        return redirect()->route('projets')->with('success', 'Merci d\'aider la planète !');
    }

    public function show($id){
        $projet = Projet::findOrFail($id);
        return view('projects.show', compact('projet'));
    }

    public function edit($id){
        $projet = Projet::findOrFail($id);
        return view('projects.edit', compact('projet'));
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
        $projet->delete();

        return redirect()->route('projets')->with('success', 'Projet supprimé avec succès');
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
        return view('projects.contribute', compact('projet'));
    }

    public function countContribution($id){
        $projet = Projet::findOrFail($id);
        $count = $projet->contributions->count();
        $totalAmount = $projet->contributions->sum('amount');
        
        return view('projects.count', compact('count','amount'));
    }
}
