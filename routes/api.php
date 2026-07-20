<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\HeroImageController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\AwardController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::post('login', [AuthController::class, 'login']);

// Public Read Routes
Route::get('proyectos', [ProyectoController::class, 'index']);
Route::get('proyectos/{id}', [ProyectoController::class, 'show']);
Route::get('settings', [SettingController::class, 'index']);
Route::get('stats', [StatController::class, 'index']);
Route::get('profile', [ProfileController::class, 'index']);
Route::get('hero-images', [HeroImageController::class, 'index']);
Route::get('sections', [SectionController::class, 'index']);
Route::get('services', [ServiceController::class, 'index']);
Route::get('testimonials', [TestimonialController::class, 'index']);
Route::get('awards', [AwardController::class, 'index']);
Route::get('logos', [LogoController::class, 'index']);
Route::get('clients', [ClientController::class, 'index']);
Route::get('skills', [SkillController::class, 'index']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{id}', [ProjectController::class, 'show']);

// Protected Routes (CMS)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    // Proyectos
    Route::post('proyectos', [ProyectoController::class, 'store']);
    Route::put('proyectos/{id}', [ProyectoController::class, 'update']);
    Route::match(['put', 'post'], 'proyectos/{id}', [ProyectoController::class, 'update']); // FormData fix
    Route::delete('proyectos/{id}', [ProyectoController::class, 'destroy']);

    // Settings
    Route::put('settings/{key}', [SettingController::class, 'update']);
    Route::post('settings/upload', [SettingController::class, 'upload']);

    // Stats
    Route::post('stats', [StatController::class, 'store']);
    Route::put('stats/{id}', [StatController::class, 'update']);
    Route::delete('stats/{id}', [StatController::class, 'destroy']);

    // Profile
    Route::put('profile', [ProfileController::class, 'update']);
    Route::match(['put', 'post'], 'profile', [ProfileController::class, 'update']);

    // Hero Images
    Route::put('hero-images/{type}', [HeroImageController::class, 'update']);
    Route::match(['put', 'post'], 'hero-images/{type}', [HeroImageController::class, 'update']);

    // Sections
    Route::put('sections/{slug}', [SectionController::class, 'update']);

    // Services
    Route::post('services', [ServiceController::class, 'store']);
    Route::get('services/{id}', [ServiceController::class, 'show']);
    Route::put('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{id}', [ServiceController::class, 'destroy']);

    // Testimonials
    Route::post('testimonials', [TestimonialController::class, 'store']);
    Route::get('testimonials/{id}', [TestimonialController::class, 'show']);
    Route::put('testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('testimonials/{id}', [TestimonialController::class, 'destroy']);

    // Awards
    Route::post('awards', [AwardController::class, 'store']);
    Route::get('awards/{id}', [AwardController::class, 'show']);
    Route::put('awards/{id}', [AwardController::class, 'update']);
    Route::delete('awards/{id}', [AwardController::class, 'destroy']);

    // Logos
    Route::delete('skills/{skill}', [SkillController::class, 'destroy']);

    // Projects
    Route::post('projects', [ProjectController::class, 'store']);
    Route::put('projects/{project}', [ProjectController::class, 'update']);
    Route::delete('projects/{project}', [ProjectController::class, 'destroy']);

    // Users
    Route::get('users', [\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::post('users', [\App\Http\Controllers\Api\UserController::class, 'store']);
    Route::delete('users/{user}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);

    // Messages
    Route::get('messages', [\App\Http\Controllers\Api\MessageController::class, 'index']);
    Route::get('messages/unread-count', [\App\Http\Controllers\Api\MessageController::class, 'unreadCount']);
    Route::get('messages/{id}', [\App\Http\Controllers\Api\MessageController::class, 'show']);
    Route::delete('messages/{id}', [\App\Http\Controllers\Api\MessageController::class, 'destroy']);
});

// Public Message Route
// Public Message Route
Route::post('messages', [\App\Http\Controllers\Api\MessageController::class, 'store']);

// Public Chat Routes
Route::post('chat/start', [\App\Http\Controllers\Api\ChatController::class, 'start']);
Route::post('chat/send', \App\Http\Controllers\Api\ChatWebhookController::class);
Route::post('chat/messages', [\App\Http\Controllers\Api\ChatController::class, 'getMessages']);

// Protected Chat Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/chat/conversations', [\App\Http\Controllers\Api\ChatController::class, 'adminIndex']);
    Route::get('admin/chat/conversations/{id}', [\App\Http\Controllers\Api\ChatController::class, 'adminShow']);
    Route::post('admin/chat/conversations/{id}/reply', [\App\Http\Controllers\Api\ChatController::class, 'adminReply']);
    Route::put('admin/chat/conversations/{id}/close', [\App\Http\Controllers\Api\ChatController::class, 'adminClose']);
});

