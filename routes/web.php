<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\InternshipsController;
use App\Http\Controllers\PeoplesController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/welcome');
});

//demande controller
Route::get('/dashboard',[DemandeController::class,'index'])->middleware('auth')->name('dashboard');
Route::get('/demandeList',[DemandeController::class,'DemandeList'])->middleware('auth')->name('demandeList');
Route::get('/addDemande',[DemandeController::class,'create'])->middleware('auth')->name('CreateDemande');
Route::post('/storeDemande',[DemandeController::class,'store'])->middleware('auth')->name('storeDemande');
Route::get('/demande/add/{person_id?}', [DemandeController::class, 'addDemande'])->name('addDemande');
Route::get('/demande/{id}', [DemandeController::class, 'show'])->middleware('auth')->name('showdemande');
Route::get('/demande/{id}/download-cv', [DemandeController::class, 'downloadCV'])->middleware('auth')->name('demande.downloadCV');
Route::get('/demande/{id}/edit', [DemandeController::class, 'edit'])->middleware('auth')->name('editDemande');
Route::put('/demande/{id}', [DemandeController::class, 'update'])->middleware('auth')->name('updateDemande');


//people controller
Route::get('/peopleList',[PeoplesController::class,'index'])->middleware('auth')->name('peopleList');
Route::get('/addPerson', [PeoplesController::class, 'create'])->middleware('auth')->name('CreatePerson');
Route::post('/storePerson', [PeoplesController::class, 'store'])->middleware('auth')->name('storePerson');
Route::get('/person/{id}', [PeoplesController::class, 'show'])->middleware('auth')->name('showPerson');
Route::get('/person/{id}/edit', [PeoplesController::class, 'edit'])->middleware('auth')->name('editPerson');
Route::put('/person/{id}', [PeoplesController::class, 'update'])->middleware('auth')->name('updatePerson');

//internship  controller
Route::get('/internshipList', [InternshipsController::class, 'index'])->middleware('auth')->name('internshipList');
Route::get('/intern/{id}', [InternshipsController::class, 'show'])->middleware('auth')->name('showIntern');
Route::get('/internship/{id}/edit', [InternshipsController::class, 'edit'])->middleware('auth')->name('editInternship');
Route::put('/internship/{id}', [InternshipsController::class, 'update'])->middleware('auth')->name('internship.update');
Route::put('/internships/{id}/update-dates', [InternshipsController::class, 'updateDates'])->name('internships.updateDates');

//absence controller
Route::get('/absenceList', [AbsenceController::class, 'index'])->middleware('auth')->name('absenceList');
Route::get('/absence/create/{internship}', [AbsenceController::class, 'create'])->middleware('auth')->name('CreateAbsence');
Route::post('/absence/store', [AbsenceController::class, 'store'])->middleware('auth')->name('StoreAbsence');

//university controller
Route::get('/universityList', [UniversityController::class, 'index'])->middleware('auth')->name('universityList');
Route::post('/storeUniversity', [UniversityController::class, 'store'])->middleware('auth')->name('storeUniversity');

//diploma controller
Route::get('/diplomaList', [DiplomaController::class, 'index'])->middleware('auth')->name('diplomaList');
Route::post('/storeDiploma', [DiplomaController::class, 'store'])->middleware('auth')->name('storeDiploma');
Route::put('/diploma/{id}', [DiplomaController::class, 'update'])->middleware('auth')->name('updateDiploma');
Route::delete('diplomas/{id}', [DiplomaController::class,'destroy'])->middleware('auth')->name('deleteDiplom');



//user controller
Route::get('/userList', [UsersController::class, 'index'])->middleware('auth')->name('userList');

//auth controller
Route::get('/login',[AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/register',[AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register',[AuthController::class, 'register'])->name('register');
