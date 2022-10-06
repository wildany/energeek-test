<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(JobController::class)->group(function () {
    Route::post('/job', 'createJob');
    Route::get('/job', 'getAllJob');
    Route::get('/job/{id}', 'getJobById')->where('id', '[0-9]+');
    Route::put('/job', 'updateJob');
    Route::delete('/job', 'deleteJob');
});

Route::controller(SkillController::class)->group(function () {
    Route::post('/skill', 'createSkill');
    Route::get('/skill', 'getAllSkills');
    Route::get('/skill/{id}', 'getSkillById')->where('id', '[0-9]+');
    Route::put('/skill', 'updateSkill');
    Route::delete('/skill', 'deleteSkill');
});

Route::controller(CandidateController::class)->group(function () {
    Route::post('/candidate', 'createCandidate');
    Route::get('/candidate', 'getAllCandidates');
    Route::get('/candidate/{id}', 'getCandidateById')->where('id', '[0-9]+');
    Route::put('/candidate', 'updateCandidate');
    Route::delete('/candidate', 'deleteCandidate');
});
