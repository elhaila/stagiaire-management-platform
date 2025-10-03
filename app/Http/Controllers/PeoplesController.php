<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PeoplesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people=Person::all();
        return view('peopleList',compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addPerson');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; exit;
        $request->validate([
            'full_name' => 'required|string|max:255|unique:people,fullname',
            'cin'       => 'required|string|max:20|unique:people,cin',
            'email'     => 'required|email|unique:people,email',
            'phone'     => 'required|string|max:20',
        ], [
            'full_name.unique' => 'This full name is already registered.',
            'cin.unique'   => 'This CIN is already registered.',
            'email.unique' => 'This email is already in use.',
        ]);

        $person = Person::create([
            'fullname' => $request->input('full_name'),
            'cin' => $request->input('cin'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('showPerson', $person->id)
            ->with('success', 'A new person has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $person = Person::with([
            'demandes.university',
            'demandes.diplome', 
            'demandes.internships.absences',
            'demandes.internships.user'
        ])->findOrFail($id);

        $stats = [
            'total_demandes' => $person->demandes->count(),
            'total_internships' => $person->internships->count(),
            'total_absences' => $person->absences->count(),
            'demandes_by_status' => $person->demandes->groupBy('status'),
            'demandes_by_type' => $person->demandes->groupBy('type'),
        ];

        return view('peopleDetails', compact('person', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $person = Person::findOrFail($id);
        return view('peopleEdit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $person = Person::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'cin'      => 'required|string|max:20|unique:people,cin,' . $id,
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
        ]);

        $person->update([
            'fullname' => $request->fullname,
            'cin'      => $request->cin,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'city'     => $request->city,
        ]);

        return redirect()->route('showPerson', $person->id)
            ->with('success', 'Person details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
