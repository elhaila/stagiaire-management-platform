<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Services\FinStageDocumentGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InternshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Internships = Internship::with([
            'demande.person', 
            'demande.diplome', 
            'demande.university',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('internshipsList', compact('Internships'));
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
    public function show(string $id)
    {
        $internships = Internship::with([
            'demande.person', 
            'demande.diplome', 
            'demande.university',
            'user'
        ])->findOrFail($id);
        // echo '<pre>' . print_r($internships->toArray(), true) . '</pre>';exit;
        return view('showInternship', compact('internships'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $internship = Internship::with([
            'demande.person', 
            'demande.diplome', 
            'demande.university',
            'user'
        ])->findOrFail($id);
        $users = User::all();
        // echo '<pre>' . print_r($internship->user->toArray(), true) . '</pre>';exit;
        return view('editInternship', compact('internship', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'supervisor' => 'required|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'date_fiche_fin_stage' => 'nullable|date',
            'date_depot_rapport' => 'nullable|date',
            'Project_name' => 'nullable|string'
        ]);
        // echo '<pre>' . print_r($request->all(), true) . '</pre>';exit;
        $internship = Internship::findOrFail($id);

        // Update fields
        $internship->user_id = $request->supervisor;
        $internship->Project_name = $request->Project_name;
        $internship->start_date = $request->start;
        $internship->end_date = $request->end;
        $internship->date_fiche_fin_stage = $request->date_fiche_fin_stage;
        $internship->date_depot_rapport_stage = $request->date_depot_rapport;
        $internship->save();

        return redirect()
            ->route('showIntern', $internship->id)
            ->with('success', 'Internship updated successfully!');
    }

    public function updateDates(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'date_fiche_fin_stage' => 'nullable|date',
            'date_depot_rapport_stage' => 'nullable|date',
            'evaluation' => 'nullable|string',
        ]);
        // echo '<pre>' . print_r($request->all(), true) . '</pre>';exit;
        try {
            $internship = Internship::findOrFail($id);
            $internship->date_fiche_fin_stage = $request->date_fiche_fin_stage;
            $internship->date_depot_rapport_stage = $request->date_depot_rapport_stage;
            $internship->evaliation = $request->evaluation;
            $internship->status = $request->status;

            $internship->save();

            return redirect()
                ->route('internshipList')
                ->with('success', 'Internship completion dates and evaluation updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'An error occurred while updating the data: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function generateFinStageDocument($id)
    {
        // echo '<pre>' . print('internship id is :'. $id) . '</pre>';exit;
        try {
            $internship = Internship::with([
                'demande.person',
                'demande.university', 
                'demande.diplome',
                'user',
                'absences'
            ])->findOrFail($id);

            // echo '<pre>' . print_r($internship->all(), true) . '</pre>';exit;

            // Check if internship is terminated
            if ($internship->status !== 'terminated') {
                return back()->withErrors(['error' => 'Le document ne peut être généré que pour les stages terminés.']);
            }

            // echo '<pre>' . print('status is :'. $internship->status) . '</pre>';exit;

            $generator = new FinStageDocumentGenerator();

            // Generate the document
            $documentPath = $generator->generateDocument($internship);

            // Update internship record with document path
            $internship->update(['fiche_fin_stage' => $documentPath]);

            // Return file download
            $fullPath = storage_path('app/public/' . $documentPath);
            
            if (file_exists($fullPath)) {
                return response()->download($fullPath, basename($documentPath), [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]);
            } else {
                return back()->withErrors(['error' => 'Erreur lors de la génération du document.']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la génération du document: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
