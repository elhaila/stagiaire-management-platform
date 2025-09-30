<?php

namespace App\Services;

use App\Models\Internship;
use App\Models\Absence;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FinStageDocumentGenerator
{
    protected $templatePath;

    public function __construct()
    {
        // Path to your Word template
        $this->templatePath = storage_path('app/templates/fin_stage_template.docx');
    }

    /**
     * Generate Fin de Stage document for an internship
     */
    public function generateDocument(Internship $internship)
    {
        try {
            // Check if template exists
            if (!file_exists($this->templatePath)) {
                throw new \Exception('Template file not found: ' . $this->templatePath);
            }

            // Load the template
            $templateProcessor = new TemplateProcessor($this->templatePath);
            
            // Prepare data
            $data = $this->prepareData($internship);

            // Replace template variables
            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value ?? '');
            }

            // Generate filename
            $fileName = $this->generateFileName($internship);
            $outputPath = storage_path('app/public/fin_stage_documents/' . $fileName);

            // Ensure directory exists
            if (!file_exists(dirname($outputPath))) {
                mkdir(dirname($outputPath), 0755, true);
            }

            // Save the document
            $templateProcessor->saveAs($outputPath);

            // Return the public path
            return 'fin_stage_documents/' . $fileName;

        } catch (\Exception $e) {
            throw new \Exception('Error generating document: ' . $e->getMessage());
        }
    }

    /**
     * Prepare data for template replacement based on the provided template format
     */
    protected function prepareData(Internship $internship)
    {
        $person = $internship->demande->person;
        $supervisor = $internship->user;

        // Calculate total absence days using the corrected method
        $totalAbsenceDays = $this->calculateAbsenceDays($internship);

        // Format dates in dd/mm/yyyy format as required
        $startDate = Carbon::parse($internship->start_date);
        $endDate = Carbon::parse($internship->end_date);
        $todayDate = Carbon::now();

        return [
            // Template variables matching your document
            'today_date' => $todayDate->format('d/m/Y'),
            'intern_name' => $person->fullname ?? 'N/A',
            'start_date' => $startDate->format('d/m/Y'),
            'end_date' => $endDate->format('d/m/Y'),
            'total_absence_days' => $totalAbsenceDays,
            'project_name' => $internship->project_name ?? 'Non spécifié',
            'supervisor_name' => $supervisor->name ?? 'Non assigné',
            'Evaluation_General' => $this->formatEvaluationGeneral($internship->evaliation),
        ];
    }

    /**
     * Calculate total absence days for the internship - CORRECTED VERSION
     */
    protected function calculateAbsenceDays(Internship $internship)
    {
        try {
            // Method 1: Using Eloquent (Recommended)
            $totalDays = 0;
            
            $absences = Absence::where('internship_id', $internship->id)->get();
            
            foreach ($absences as $absence) {
                $startDate = Carbon::parse($absence->start_date);
                
                // Handle cases where end_date might be null (single day absence)
                $endDate = $absence->end_date ? Carbon::parse($absence->end_date) : $startDate;
                
                // Calculate days between start and end (inclusive)
                $days = $startDate->diffInDays($endDate) + 1;
                $totalDays += $days;
            }
            
            return $totalDays;
            
        } catch (\Exception $e) {
            // Method 2: Fallback using raw SQL with better error handling
            return $this->calculateAbsenceDaysSQL($internship->id);
        }
    }

    /**
     * Alternative method using raw SQL (fallback)
     */
    protected function calculateAbsenceDaysSQL($internshipId)
    {
        try {
            // Get database connection name to determine the correct SQL syntax
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            
            if ($driver === 'mysql') {
                // MySQL syntax
                $result = DB::selectOne('
                    SELECT SUM(
                        CASE 
                            WHEN end_date IS NULL THEN 1 
                            ELSE DATEDIFF(end_date, start_date) + 1 
                        END
                    ) AS total_absence_days
                    FROM absences
                    WHERE internship_id = ?
                ', [$internshipId]);
            } elseif ($driver === 'sqlite') {
                // SQLite syntax
                $result = DB::selectOne('
                    SELECT SUM(
                        CASE 
                            WHEN end_date IS NULL THEN 1 
                            ELSE (julianday(end_date) - julianday(start_date)) + 1 
                        END
                    ) AS total_absence_days
                    FROM absences
                    WHERE internship_id = ?
                ', [$internshipId]);
            } elseif ($driver === 'pgsql') {
                // PostgreSQL syntax
                $result = DB::selectOne('
                    SELECT SUM(
                        CASE 
                            WHEN end_date IS NULL THEN 1 
                            ELSE (end_date - start_date) + 1 
                        END
                    ) AS total_absence_days
                    FROM absences
                    WHERE internship_id = ?
                ', [$internshipId]);
            } else {
                // Default fallback - use Eloquent method
                return $this->calculateAbsenceDaysEloquent($internshipId);
            }

            return (int)($result->total_absence_days ?? 0);
            
        } catch (\Exception $e) {
            // If SQL fails, try Eloquent as last resort
            return $this->calculateAbsenceDaysEloquent($internshipId);
        }
    }

    /**
     * Pure Eloquent method (most reliable)
     */
    protected function calculateAbsenceDaysEloquent($internshipId)
    {
        try {
            $absences = DB::table('absences')->where('internship_id', $internshipId)->get();
            $totalDays = 0;
            
            foreach ($absences as $absence) {
                $startDate = Carbon::parse($absence->start_date);
                $endDate = $absence->end_date ? Carbon::parse($absence->end_date) : $startDate;
                $totalDays += $startDate->diffInDays($endDate) + 1;
            }
            
            return $totalDays;
            
        } catch (\Exception $e) {
            // Last resort - return 0
            return 0;
        }
    }

    /**
     * Format the general evaluation text
     */
    protected function formatEvaluationGeneral($evaluation)
    {
        if (empty($evaluation)) {
            return 'Aucune évaluation fournie.';
        }

        // Clean and format the evaluation text
        $formattedEvaluation = trim($evaluation);
        
        // Ensure proper sentence structure
        if (!str_ends_with($formattedEvaluation, '.') && 
            !str_ends_with($formattedEvaluation, '!') && 
            !str_ends_with($formattedEvaluation, '?')) {
            $formattedEvaluation .= '.';
        }

        return $formattedEvaluation;
    }

    /**
     * Generate filename for the document
     */
    protected function generateFileName(Internship $internship)
    {
        $personName = $internship->demande->person->fullname ?? 'intern';
        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $personName);
        $date = Carbon::now()->format('Y_m_d_H_i');
        
        return "fiche_fin_stage_{$cleanName}_{$date}.docx";
    }

    /**
     * Debug method to check absence calculation
     */
    public function debugAbsenceCalculation(Internship $internship)
    {
        $absences = Absence::where('internship_id', $internship->id)->get();
        $debug = [
            'internship_id' => $internship->id,
            'total_absences_count' => $absences->count(),
            'absences_details' => [],
            'total_days_calculated' => 0
        ];
        
        foreach ($absences as $absence) {
            $startDate = Carbon::parse($absence->start_date);
            $endDate = $absence->end_date ? Carbon::parse($absence->end_date) : $startDate;
            $days = $startDate->diffInDays($endDate) + 1;
            
            $debug['absences_details'][] = [
                'id' => $absence->id,
                'start_date' => $absence->start_date,
                'end_date' => $absence->end_date,
                'calculated_days' => $days,
                'reason' => $absence->reason
            ];
            
            $debug['total_days_calculated'] += $days;
        }
        
        return $debug;
    }

    /**
     * Alternative method to generate document with custom evaluation ratings
     */
    public function generateDocumentWithRatings(Internship $internship, array $ratings = [])
    {
        try {
            if (!file_exists($this->templatePath)) {
                throw new \Exception('Template file not found: ' . $this->templatePath);
            }

            $templateProcessor = new TemplateProcessor($this->templatePath);
            
            // Prepare basic data
            $data = $this->prepareData($internship);
            
            // Add rating data if provided
            $defaultRatings = [
                'competences_techniques' => 'BON',
                'competences_methodologiques' => 'A.BON',
                'competences_communicatives' => 'BON',
                'assiduite' => 'BON',
                'esprit_creativite' => 'BON',
                'integration_groupe' => 'BON',
                'qualite_travaux' => 'BON'
            ];
            
            $finalRatings = array_merge($defaultRatings, $ratings);
            $data = array_merge($data, $finalRatings);

            // Replace template variables
            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value ?? '');
            }

            // Generate and save document
            $fileName = $this->generateFileName($internship);
            $outputPath = storage_path('app/public/fin_stage_documents/' . $fileName);

            if (!file_exists(dirname($outputPath))) {
                mkdir(dirname($outputPath), 0755, true);
            }

            $templateProcessor->saveAs($outputPath);
            return 'fin_stage_documents/' . $fileName;

        } catch (\Exception $e) {
            throw new \Exception('Error generating document with ratings: ' . $e->getMessage());
        }
    }

    /**
     * Get template variables for debugging purposes
     */
    public function getTemplateVariables(Internship $internship)
    {
        return $this->prepareData($internship);
    }
}