<?php

use App\Http\Controllers\API\LiveKitController;
use App\Http\Controllers\CCBillController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VideosController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// channel is subscribed
Route::get('subscriptions/is-subscribed/{user}', [SubscriptionController::class, 'isSubscribedTo'])->name('subscription.isSubscribed');


// streaming
Route::get('stream/tiers/{user}', [ChannelController::class, 'getTiers'])->name('streaming.getTiers');
Route::post('streaming/update-status', [LiveKitController::class, 'updateOwnStatus'])->name('streaming.updateOwnStatus');
Route::post('streaming/validate-key', [LiveKitController::class, 'validateKey'])->name('streaming.validateKey');

// chat
Route::get('chat/latest-messages/{roomName}', [ChatController::class, 'latestMessages'])->name('chat.latestMessages');
Route::post('chat/send-message/{user}', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

// schedule
Route::get('schedule/for-channel/{user}', [ScheduleController::class, 'getSchedule'])->name('schedule.get');
Route::get('schedule/info/{user}', [ScheduleController::class, 'getScheduleInfo'])->name('schedule.getInfo');
Route::post('schedule/save', [ScheduleController::class, 'saveSchedule'])->name('schedule.save');

// follow
Route::get('follow/{user}', [ProfileController::class, 'toggleFollow'])->name('follow');

// search
Route::get('search', [ChannelController::class, 'search'])->name('channel.search');

// notifications
Route::post('notifications/mark-as-read/{notification}', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.markAllRead');

// video
Route::post('upload-video-chunks', [VideosController::class, 'uploadChunkedVideo'])->name('video.uploadChunks');

// paypal IPN
Route::any('paypal/redirect-to-processing', [PayPalController::class, 'redirect'])->name('paypal.redirect-to-processing');
Route::post('paypal/ipn', [PayPalController::class, 'ipn'])->name('paypal.ipn');

// ccbill webhooks
Route::any('ccbill/webhooks', [CCBillController::class, 'webhooks'])->name('ccbill.webhooks');

// user api modal info
Route::post('profile/modal-user-info/{user}', [ProfileController::class, 'modalUserInfo'])->name('profile.modalUserInfo');
