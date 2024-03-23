<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// admin panel routes
Route::get('admin', [Admin::class, 'dashboard'])->name('admin.dashboard');

// Vendors Related
Route::get('admin/users', [Admin::class, 'users']);
Route::get('admin/user/{user}/add-tokens', [Admin::class, 'adjustTokenForm']);
Route::post('admin/save-token-balance/{user}', [Admin::class, 'saveTokenBalance']);
Route::get('admin/streamers', [Admin::class, 'streamers'])->name('admin.streamers');
Route::get('admin/approve-streamer', [Admin::class, 'approveStreamer'])->name('admin.approveStreamer');
Route::get('admin/loginAs/{vendorId}', [Admin::class, 'loginAsVendor']);
Route::get('admin/add-plan/{vendorId}', [Admin::class, 'addPlanManually']);
Route::post('admin/add-plan/{vendorId}', [Admin::class, 'addPlanManuallyProcess']);
Route::get('admin/users/setadmin/{user}', [Admin::class, 'setAdminRole']);
Route::get('admin/users/unsetadmin/{user}', [Admin::class, 'unsetAdminRole']);
Route::get('admin/users/ban/{user}', [Admin::class, 'banUser']);
Route::get('admin/users/unban/{user}', [Admin::class, 'unbanUser']);
Route::get('admin/edit-user/{user}', [Admin::class, 'editUser']);
Route::post('admin/update-user/{user}', [Admin::class, 'updateUser']);

Route::get('admin/streamer-bans', [Admin::class, 'streamerBans'])->name('admin.streamerBans');

// Payout Requests
Route::get('admin/payout-requests', [Admin::class, 'payoutRequests']);
Route::get('admin/payout/mark-as-paid/{withdrawal}', [Admin::class, 'markPaymentRequestAsPaid']);

// Videos
Route::get('admin/videos', [Admin::class, 'videos']);
Route::get('admin/videos/edit/{video}', [Admin::class, 'editVideo']);
Route::post('admin/videos/save/{video}', [Admin::class, 'saveVideo']);

// Tokens
Route::get('admin/token-sales', [Admin::class, 'tokenSales']);
Route::get('admin/token-packs', [Admin::class, 'tokenPacks']);
Route::get('admin/add-token-sale', [Admin::class, 'addTokenSale'])->name('admin.addTokenSale');
Route::post('admin/save-token-sale/{user}', [Admin::class, 'saveTokenSale']);
Route::get('admin/create-token-pack', [Admin::class, 'createTokenPack']);
Route::post('admin/add-token-pack', [Admin::class, 'addTokenPack']);
Route::get('admin/edit-token-pack/{tokenPack}', [Admin::class, 'editTokenPack']);
Route::post('admin/update-token-pack/{tokenPack}', [Admin::class, 'updateTokenPack']);


// Subscriptions related
Route::get('admin/subscriptions', [Admin::class, 'subscriptions']);
Route::get('admin/edit-subscription/{subscription}', [Admin::class, 'editSubscription']);
Route::get('admin/delete-subscription/{subscription}', [Admin::class, 'deleteSubscription']);
Route::post('admin/update-subscription/{subscription}', [Admin::class, 'updateSubscription']);

// Tips Related
Route::get('admin/tips', [Admin::class, 'tips']);


// Category Related
Route::get('admin/categories', [Admin::class, 'categories_overview']);
Route::post('admin/add_category', [Admin::class, 'add_category']);
Route::post('admin/update_category', [Admin::class, 'update_category']);
Route::get('admin/video-categories', [Admin::class, 'video_categories']);
Route::post('admin/add_video_category', [Admin::class, 'add_video_category']);
Route::post('admin/update_video_category', [Admin::class, 'update_video_category']);

// CMS
Route::get('admin/cms', [Admin::class, 'pages'])->name('admin-cms');
Route::post('admin/cms', [Admin::class, 'create_page']);
Route::get('admin/cms-edit-{page}', [Admin::class, 'showUpdatePage']);
Route::post('admin/cms-edit-{page}', [Admin::class, 'processUpdatePage']);
Route::get('admin/cms-delete/{page}', [Admin::class, 'deletePage']);
Route::post('admin/cms/upload-image', [Admin::class, 'uploadImageFromCMS']);

// Payments Setup
Route::get('admin/configuration/payment', [Admin::class, 'paymentsSetup']);
Route::post('admin/configuration/payment', [Admin::class, 'paymentsSetupProcess']);

// Admin config logins
Route::get('admin/config-logins', [Admin::class, 'configLogins']);
Route::post('admin/save-logins', [Admin::class, 'saveLogins']);

Route::get('admin/configuration', [Admin::class, 'configuration']);
Route::get('admin/configuration/streaming', [Admin::class, 'streamingConfig']);
Route::post('admin/configuration/streaming', [Admin::class, 'saveStreamingConfig']);
Route::get('admin/configuration/chat', [Admin::class, 'chatConfig']);
Route::post('admin/configuration/chat', [Admin::class, 'saveChatConfig']);
Route::post('admin/configuration', [Admin::class, 'configurationProcess']);

// Mail Server Configuration
Route::get('admin/mailconfiguration', [Admin::class, 'mailConfiguration']);
Route::post('admin/mailconfiguration', [Admin::class, 'updateMailConfiguration']);
Route::get('admin/mailtest', [Admin::class, 'mailtest']);

// Cloud settings
Route::get('admin/cloud', [Admin::class, 'cloudSettings']);
Route::post('admin/save-cloud-settings', [Admin::class, 'saveCloudSettings']);
