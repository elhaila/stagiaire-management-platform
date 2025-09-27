<?php

namespace App\Services;

use App\Models\Internship;
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
            // It's often better to log the error for debugging
            // Log::error('Error generating document: ' . $e->getMessage());
            throw new \Exception('Error generating document: ' . $e->getMessage());
        }
    }

    /**
     * Prepare data for template replacement
     */
    protected function prepareData(Internship $internship)
    {
        $person = $internship->demande->person;
        $university = $internship->demande->university;
        $diploma = $internship->demande->diplome;
        $supervisor = $internship->user;

        // Calculate duration
        $startDate = Carbon::parse($internship->start_date);
        $endDate = Carbon::parse($internship->end_date);
        $durationDays = $startDate->diffInDays($endDate) + 1; // Add 1 to be inclusive
        $durationMonths = $startDate->diffInMonths($endDate);

        // Get total absence days
        $absenceResult = DB::selectOne('SELECT SUM(DATEDIFF(day, start_date, end_date) + 1) AS total_absence_days
            FROM absences
            WHERE internship_id = ?', [$internship->id]);

        // Extract the value from the result object, default to 0 if null.
        $totalAbsenceDays = $absenceResult->total_absence_days ?? 0;

        return [
            // Personal Information
            'intern_name' => $person->fullname ?? 'N/A',
            'intern_cin' => $person->cin ?? 'N/A',
            'intern_email' => $person->email ?? 'N/A',
            'intern_phone' => $person->phone ?? 'N/A',
            
            // Academic Information
            'university_name' => $university->name ?? 'N/A',
            'diploma_name' => $diploma->name ?? 'N/A',
            'internship_type' => ucfirst($internship->demande->type ?? 'N/A'),
            
            // Internship Details
            'project_name' => $internship->project_name ?? 'N/A',
            'supervisor_name' => $supervisor->name ?? 'N/A',
            'start_date' => $startDate->format('d/m/Y'),
            'end_date' => $endDate->format('d/m/Y'),
            'start_date_french' => $this->formatDateInFrench($startDate),
            'end_date_french' => $this->formatDateInFrench($endDate),
            
            // Duration Information
            'duration_days' => $durationDays,
            'duration_months' => $durationMonths,
            'duration_text' => $this->formatDurationText($durationDays),
            
            // Attendance Information
            'total_absence_days' => $totalAbsenceDays,
            
            // Completion Information
            'fiche_submission_date' => $internship->date_fiche_fin_stage ? 
                Carbon::parse($internship->date_fiche_fin_stage)->format('d/m/Y') : 'Non soumis',
            'report_submission_date' => $internship->date_depot_rapport_stage ? 
                Carbon::parse($internship->date_depot_rapport_stage)->format('d/m/Y') : 'Non soumis',
            
            // Current Date
            'generation_date' => Carbon::now()->format('d/m/Y'),
            'generation_date_french' => $this->formatDateInFrench(Carbon::now()),
            
            // Company Information (you can customize these)
            'company_name' => config('app.company_name', 'Votre Entreprise'),
            'company_address' => config('app.company_address', 'Adresse de l\'entreprise'),
            'company_phone' => config('app.company_phone', 'Téléphone'),
            'company_email' => config('app.company_email', 'Email'),
            
            // Status Information
            'internship_status' => ucfirst($internship->status),
            'completion_status' => $this->getCompletionStatus($internship),
        ];
    }

    /**
     * Generate filename for the document
     */
    protected function generateFileName(Internship $internship)
    {
        $personName = $internship->demande->person->fullname ?? 'intern';
        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $personName);
        $date = Carbon::now()->format('Y_m_d');
        
        return "fin_stage_{$cleanName}_{$date}.docx";
    }

    /**
     * Format date in French
     */
    protected function formatDateInFrench(Carbon $date)
    {
        $months = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];

        return $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
    }

    /**
     * Format duration text
     */
    protected function formatDurationText($days)
    {
        if ($days <= 0) {
            return '0 jours';
        }
        if ($days < 30) {
            return $days . ' jours';
        } elseif ($days < 365) {
            $months = floor($days / 30);
            $remainingDays = $days % 30;
            
            if ($remainingDays > 0) {
                return $months . ' mois et ' . $remainingDays . ' jours';
            } else {
                return $months . ' mois';
            }
        } else {
            $years = floor($days / 365);
            $remainingDays = $days % 365;
            $months = floor($remainingDays / 30);
            
            $text = $years . ' an' . ($years > 1 ? 's' : '');
            if ($months > 0) {
                $text .= ' et ' . $months . ' mois';
            }
            
            return $text;
        }
    }

    /**
     * Get completion status
     */
    protected function getCompletionStatus(Internship $internship)
    {
        $hasReport = !empty($internship->date_depot_rapport_stage);
        $hasFiche = !empty($internship->date_fiche_fin_stage);
        
        if ($hasReport && $hasFiche) {
            return 'Complètement terminé';
        } elseif ($hasReport || $hasFiche) {
            return 'Partiellement terminé';
        } else {
            return 'En attente des documents';
        }
    }
}
