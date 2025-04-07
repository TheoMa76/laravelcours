<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contribution;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandleSorting;

class AdminContributionController extends Controller
{
    use HandleSorting;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $validSorts = ['id', 'user_id', 'amount', 'type', 'created_at'];
        $relationSorts = ['user_name', 'project_name'];
        $contributions = Contribution::query();

        [$sort, $direction] = $this->applySorting($contributions, $validSorts, $relationSorts);
        $contributions = $contributions->paginate(20);

        foreach ($contributions as $contribution) {
            $contribution->user_name = $contribution->user->name;
            $contribution->project_name = $contribution->projet->name;
            $contribution->type = ucfirst($contribution->type);
        }

        $contributions->setCollection(
            $this->sortCollection($contributions->getCollection(), $sort, $direction, $relationSorts)
        );
        return view('admin.contributions.index', compact('contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contribution $contribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        //
    }
}
