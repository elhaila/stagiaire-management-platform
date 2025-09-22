<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Demande;
use App\Models\Diplome;
use App\Models\Internship;
use App\Models\Person;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $recentInternships = Internship::with([
            'demande.person', 
            'demande.diplome', 
            'demande.university',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        $recentAbsences = Absence::with(['internship.demande.person'])
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // Get statistics
        $totalInternships = Internship::count();
        $activeInternships = Internship::where('status', 'active')->count();
        $pendingInternships = Internship::where('status', 'pending')->count();
        $finishedInternships = Internship::where('status', 'finished')->count();
        $terminatedInternships = Internship::where('status', 'terminated')->count();
        $totalFinishedInternships = $finishedInternships + $terminatedInternships;

        $demandes = Demande::with(['person', 'university', 'diplome'])->get();

        return view('dashboard', compact(
            'recentInternships', 
            'recentAbsences', 
            'totalInternships', 
            'activeInternships', 
            'pendingInternships', 
            'totalFinishedInternships',
            'demandes'
        ));
    }

    public function DemandeList()
    {
        $today = now()->toDateString();
        $demandes = Demande::with(['person', 'university', 'diplome'])
            ->select('*')
            ->selectRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN end_date < ? THEN 2
                    WHEN status = 'rejected' THEN 3
                END as custom_order
            ", [$today])
            ->orderBy('custom_order')
            ->orderByDesc('created_at')
            ->get();

        $supervisors = User::all();

        return view('demandeList', compact('demandes', 'supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $people = DB::table('people')->orderBy('fullname')->get();
        $university = DB::table('university')->orderBy('name')->get();
        $diplome = DB::table('diplomes')->orderBy('name')->get();
        return view('addDemande', compact('people', 'university', 'diplome'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //  echo "<pre>"; print_r($request->all()); echo "</pre>";
        //  exit;

        
        $request->validate([
            'full_name' => 'required|exists:people,id',
            'university' => 'required|exists:university,id',
            'diploma' => 'required|exists:diplomes,id',
            'cv' => 'required|mimes:pdf|max:5048',
            'status' => 'required|in:pending,selected',
            'type' => 'required|string',
            'note' => 'nullable|string',
            'start' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $start = strtotime($value);
                    $tomorrow = strtotime(date('Y-m-d', strtotime('+1 day')));
                    if ($start < $tomorrow) {
                        $fail('The start date must be tomorrow or later.');
                    }
                }
            ],
            'end' => [
            'required',
            'date',
            'after_or_equal:start',
            function ($attribute, $value, $fail) use ($request) {
                $start = strtotime($request->input('start'));
                $end = strtotime($value);
                if ($end - $start < 30 * 24 * 60 * 60) {
                $fail('The end date must be at least one month after the start date.');
                }
            }
            ],
            
        ]);

        if ($request->hasFile('cv')) {
            $person = DB::table('people')->where('id', $request->input('full_name'))->first();
            $fullName = trim($person->fullname);
            $fileName = strtolower(str_replace(' ', '_', $fullName)) . '_cv.' . $request->file('cv')->getClientOriginalExtension();
            $cvPath = $request->file('cv')->storeAs('cvs', $fileName, 'public');
        } else {
            return back()->withErrors(['cv' => 'CV upload failed'])->withInput();
        }
        
        // echo "<pre>"; print_r($request->all()); echo "</pre>";
        // exit;
        $demande = new Demande();
        $demande->person_id = $request->input('full_name');
        $demande->university_id = $request->input('university');
        $demande->diplome_id = $request->input('diploma');
        $demande->type = $request->input('type');
        $demande->start_date = $request->input('start');
        $demande->end_date = $request->input('end');
        $demande->description = $request->input('note');
        $demande->cv = $cvPath;
        $demande->status = $request->input('status');
        $demande->save();

        return redirect()->route('demandeList')->with('success', 'Demande created successfully.');
    }

    public function addDemande($person_id = null)
    {
        $people = Person::all();
        $university = University::all();
        $diplome = Diplome::all();

        return view('addDemande', compact('people', 'university', 'diplome', 'person_id'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demande = Demande::with(['person', 'university', 'diplome'])->findOrFail($id);
        $users = User::all();
        return view('demandeDetails', compact('demande', 'users'));

    }

    public function downloadCV($id)
    {
        $demande = Demande::findOrFail($id);
    
        if (!$demande->cv) {
            abort(404, 'CV not found');
        }
    
        $filePath = storage_path('app/public/' . $demande->cv);
    
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
    
        // Get the original filename or create a meaningful one
        $person = $demande->person;
        $originalName = $person->fullname . '_CV.pdf';
    
        return response()->download($filePath, $originalName, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $demande = Demande::findOrFail($id);
        $university = University::all();
        $diplome = Diplome::all();
        return view('demandeEdit', compact('demande', 'university', 'diplome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        // Handle approval with internship creation
        if ($request->has('create_internship') && $request->create_internship == '1') {
            return $this->approveWithInternship($request, $demande);
        }

        // Existing update logic for regular updates
        if($request->status=='pending'){
            $request->validate([
                'university' => 'required|exists:university,id',
                'diploma' => 'required|exists:diplomes,id',
                'cv' => 'nullable|mimes:pdf|max:5048',
                'status' => 'required|in:pending,selected,approved,rejected,expired',
                'type' => 'required|string',
                'note' => 'nullable|string',
                'start' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($demande) {
                        $start = strtotime($value);
                        $originalStart = strtotime($demande->start_date);
                        $tomorrow = strtotime(date('Y-m-d', strtotime('+1 day')));
                        
                        if ($start < $tomorrow && $start !== $originalStart) {
                            $fail('The start date must be tomorrow or later.');
                        }
                    }
                ],
                'end' => [
                    'required',
                    'date',
                    'after_or_equal:start',
                    function ($attribute, $value, $fail) use ($request) {
                        $start = strtotime($request->input('start'));
                        $end = strtotime($value);
                        if ($end - $start < 30 * 24 * 60 * 60) {
                            $fail('The end date must be at least one month after the start date.');
                        }
                    }
                ],
            ]);

            $oldCvPath = $demande->cv;
            $demande->university_id = $request->university;
            $demande->diplome_id = $request->diploma;
            $demande->type = $request->type;
            $demande->start_date = $request->start;
            $demande->end_date = $request->end;
            $demande->description = $request->note;
            $demande->status = $request->status;

            if ($request->hasFile('cv')) {
                try {
                    $person = DB::table('people')->where('id', $demande->person_id)->first();
                    $fullName = trim($person->fullname);
                    
                    $timestamp = time();
                    $fileName = strtolower(str_replace(' ', '_', $fullName)) . '_cv' . $timestamp . '.' . $request->file('cv')->getClientOriginalExtension();

                    $cvPath = $request->file('cv')->storeAs('cvs', $fileName, 'public');
                    
                    if ($cvPath) {
                        $demande->cv = $cvPath;
                    } else {
                        return back()->withErrors(['cv' => 'Failed to upload CV file'])->withInput();
                    }
                    
                } catch (\Exception $e) {
                    return back()->withErrors(['cv' => 'Error uploading CV: ' . $e->getMessage()])->withInput();
                }
            }

            try {
                $demande->save();
                
                if ($request->hasFile('cv') && $oldCvPath && Storage::disk('public')->exists($oldCvPath)) {
                    Storage::disk('public')->delete($oldCvPath);
                }
                
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to update demande: ' . $e->getMessage()])->withInput();
            }

            return redirect()->route('demandeList')
                ->with('success', $demande->person->fullname . ' Demande updated successfully.');

        } elseif($request->status=='rejected'){
            $demande->status = $request->status;
            $demande->save();
            return redirect()->route('demandeList')
                ->with('success', $demande->person->fullname . ' Demande status updated successfully.');
        }
    }


    private function approveWithInternship(Request $request, $demande)
    {
        $request->validate([
            'internship_start_date' => 'required|date',
            'internship_end_date' => 'required|date|after:internship_start_date',
            'supervisor_id' => 'required|exists:users,id',
            'internship_status' => 'required|in:pending,active,finished,terminated',
        ]);

        try {
            DB::beginTransaction();

            // Update demande status to accepted
            $demande->status = 'accepted';
            $demande->save();

            // Create internship record
            $internship = new Internship();
            $internship->demand_id = $demande->id;
            $internship->user_id = $request->supervisor_id;
            $internship->start_date = $request->internship_start_date;
            $internship->end_date = $request->internship_end_date;
            $internship->status = $request->internship_status;
            $internship->save();

            DB::commit();

            return redirect()->route('demandeList')
                ->with('success', $demande->person->fullname . ' Demande approved and internship created successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to approve demande: ' . $e->getMessage()])->withInput();
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
