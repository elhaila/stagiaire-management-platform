<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absences = Absence::with('internship.demande.person', 'internship.user')->paginate(10);
        return view('absenceList', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($internshipId)
    {
       $internship = Internship::with('demande.person')->findOrFail($internshipId);

        return view('addAbsence', compact('internship'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Dynamic validation rules based on status
        $rules = [
            'internship_id' => 'required|exists:internships,id',
            'date' => 'required|date',
            'status' => 'required|in:justified,unjustified',
        ];

        // Add conditional validation for justified absences
        if ($request->status === 'justified') {
            $rules['reason'] = 'required|string|max:500';
            $rules['justification'] = 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048';
        }

        $validatedData = $request->validate($rules);

        try {
            // Get the internship with person data for file naming
            $internship = Internship::with('demande.person')->findOrFail($request->internship_id);
            
            // Check if person exists
            if (!$internship->demande || !$internship->demande->person) {
                return back()->withErrors(['internship_id' => 'Invalid internship data. Person information not found.'])->withInput();
            }

            $absence = new Absence();
            $absence->internship_id = $request->internship_id;
            $absence->date = $request->date;
            $absence->status = $request->status;
            
            // Only set reason and justification for justified absences
            if ($request->status === 'justified') {
                $absence->reason = $request->reason;

                // Handle file upload
                if ($request->hasFile('justification')) {
                    $person = $internship->demande->person;
                    $fullName = trim($person->fullname);
                    $cleanName = strtolower(str_replace([' ', '.', ',', '-'], '_', $fullName));
                    $extension = $request->file('justification')->getClientOriginalExtension();
                    $fileName = $cleanName . '_absence_' . date('Y_m_d_His') . '.' . $extension;
                    
                    $filePath = $request->file('justification')->storeAs('justifications', $fileName, 'public');
                    $absence->justification = $filePath;
                }
            } else {
                // For unjustified absences, explicitly set to null/empty
                $absence->reason = null;
                $absence->justification = null;
            }

            $absence->save();

            return redirect()
                ->route('absenceList')
                ->with('success', 'Absence recorded successfully for ' . $internship->demande->person->fullname);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'An error occurred while saving the absence: ' . $e->getMessage()])
                ->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
