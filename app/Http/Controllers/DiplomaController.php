<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiplomaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diplomas = Diplome::paginate(10);
        return view('diplomaList', compact('diplomas'));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Diplome::create([
        'name' => $request->input('name'),
    ]);
        return redirect()->route('diplomaList')->with('success', 'Diploma added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // echo "<pre>"; print_r($request->all()); echo "</pre>";
        // echo "<pre>"; print_r($id); echo "</pre>";
        // exit;
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $diploma = Diplome::findOrFail($id);
        $diploma->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('diplomaList')->with('success', 'Diploma updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demande = DB::select('select*from demandes where diplome_id = ?',[$id]);
        if(count($demande)>0){
            return redirect(route('diplomaList'))->with('error','Diploma con\'t bee deleted because there is intern have this deploma');
            exit;
        }
        Diplome::destroy($id);
        return redirect(route('diplomaList'))->with('success','Diploma have been deleted');
    }
}
