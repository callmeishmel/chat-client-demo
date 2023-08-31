<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\UserIdleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PusherWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [ChatsController::class, 'index']);
Route::get('messages/{contactId?}', [ChatsController::class, 'fetchMessages']);
Route::post('messages', [ChatsController::class, 'sendMessage']);

Route::get('current-app-user', [ChatsController::class, 'getCurrentAppUser']);
Route::get('set-user-current-contact/{contactId?}', [ChatsController::class, 'setUserCurrentContact']);
Route::get('user-contacts', [ChatsController::class, 'getUserContacts']);
Route::get('add-contact-notification/{contactId}', [ChatsController::class, 'addContactNotification']);
Route::get('remove-contact-notification/{contactId}', [ChatsController::class, 'removeContactNotification']);

Route::get('user/{user}/idle', [UserIdleController::class, 'setUserIdle']);
Route::get('user/{user}/active', [UserIdleController::class, 'setUserActive']);

Route::get('canned-message-responses/{id?}', [ChatsController::class, 'getCannedMessageResponses']);

Route::get('users', [AdminController::class, 'createUserPage']);
Route::post('users', [AdminController::class, 'createUserPost']);

Route::get('delete-user/{userId}', [AdminController::class, 'deleteUserPage']);
Route::post('delete-user/{userId}', [AdminController::class, 'deleteUserPagePost']);

Route::get('canned-messages', [AdminController::class, 'cannedMessagesPage']);
Route::post('canned-messages', [AdminController::class, 'cannedMessagesPagePost']);

Route::get('delete-canned-message/{cannedMessageId}', [AdminController::class, 'deleteCannedMessagePage']);
Route::post('delete-canned-message/{cannedMessageId}', [AdminController::class, 'deleteCannedMessagePagePost']);

Route::post('pusher/presence-webhook', [PusherWebhookController::class, 'presenceWebhook']);

Route::get('pusher/api-test', [PusherWebhookController::class, 'pusherAPICall']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
