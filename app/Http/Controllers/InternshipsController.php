<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
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
        ]);
        // echo '<pre>' . print_r($request->all(), true) . '</pre>';exit;
        $internship = Internship::findOrFail($id);

        // Update fields
        $internship->user_id = $request->supervisor;
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
        ]);

        try {
            $internship = Internship::findOrFail($id);
            
            // Update only the date fields
            $internship->date_fiche_fin_stage = $request->date_fiche_fin_stage;
            $internship->date_depot_rapport_stage = $request->date_depot_rapport_stage;
            $internship->status = $request->status;
            $internship->save();

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dates updated successfully!',
                    'data' => [
                        'date_fiche_fin_stage' => $internship->date_fiche_fin_stage,
                        'date_depot_rapport_stage' => $internship->date_depot_rapport_stage,
                        'status' => $internship->status,
                    ]
                ]);
            }

            return redirect()
                ->route('internshipList')
                ->with('success', 'Internship completion dates updated successfully!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating dates: ' . $e->getMessage()
                ], 422);
            }

            return back()
                ->withErrors(['error' => 'An error occurred while updating the dates.'])
                ->withInput();
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
