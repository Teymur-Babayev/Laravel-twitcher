<?php

use App\Events\ChatMessageEvent;
use App\Events\LiveStreamStarted;
use App\Events\LiveStreamStopped;
use App\Http\Controllers\Admin;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\BannedController;
use App\Http\Controllers\BrowseChannelsController;
use App\Http\Controllers\CCBillController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TokensController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StreamerVerificationController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\VideosController;
use App\Http\Middleware\BanMiddleware;
use App\Http\Middleware\HandleInertiaRequests;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home');


// Live Streaming Controller
Route::get('/channel/{user}', [ChannelController::class, 'userProfile'])->name('channel');
Route::get('/channel/live-stream/{user}', [ChannelController::class, 'liveStream'])->name('channel.livestream');
Route::get('/settings/channel', [ChannelController::class, 'channelSettings'])->name('channel.settings');
Route::post('/settings/channel/update', [ChannelController::class, 'updateChannelSettings'])->name('channel.update-settings');
Route::get('/channel/{user}/followers', [ChannelController::class, 'followers'])->name('channel.followers');
Route::get('/channel/{user}/subscribers', [ChannelController::class, 'subscribers'])->name('channel.subscribers');
Route::get('/channel/{user}/videos', [ChannelController::class, 'channelVideos'])->name('channel.videos');
Route::get('/live-channels', [BrowseChannelsController::class, 'liveNow'])->name('channels.live');
Route::get('/live-channel', [BrowseChannelsController::class, 'liveChannel'])->name('channels.liveNow');
Route::post('/channel/ban-user-from-room/{user}', [ChannelController::class, 'banUserFromRoom'])->name('channel.banUserFromRoom');
Route::get('/channel/banned-from-room/{user}', [ChannelController::class, 'bannedFromRoom'])->name('channel.bannedFromRoom');
Route::get('/channel/settings/banned-users', [ChannelController::class, 'bannedUsers'])->name('channel.bannedUsers');
Route::get('/channel/lif-user-ban/{roomban}', [ChannelController::class, 'liftUserBan'])->name('channel.liftUserBan');

// Streamer Verification
Route::get('/streamer/verify', [StreamerVerificationController::class, 'verifyForm'])->name('streamer.verify');
Route::get('/streamer/pending-verification', [StreamerVerificationController::class, 'pendingVerification'])->name('streamer.pendingVerification');
Route::post('/streamer/submit-verification', [StreamerVerificationController::class, 'submitVerification'])->name('streamer.submitVerification');

// Tips
Route::post('tip/send', [TipsController::class, 'sendTip'])->name('tips.send');

// Tier Settings
Route::get('/membership/channel/set-membership-tiers', [MembershipController::class, 'setMembershipTiers'])->name('membership.set-tiers');
Route::post('/membership/channel/add-tier', [MembershipController::class, 'addTier'])->name('membership.add-tier');
Route::get('/membership/channel/edit-tier/{tier}', [MembershipController::class, 'editTier'])->name('membership.edit-tier');
Route::post('/membership/channel/update-tier/{tier}', [MembershipController::class, 'updateTier'])->name('membership.update-tier');
Route::post('/membership/channel/delete-tier', [MembershipController::class, 'deleteTier'])->name('membership.delete-tier');
Route::post('/membership/save-thanks-message', [MembershipController::class, 'saveThanks'])->name('membership.save-thanks');

// Tokens
Route::any('/get-tokens', [TokensController::class, 'getTokens'])->name('token.packages');
Route::get('/tokens/select-gateway/{tokenPack}', [TokensController::class, 'selectGateway'])->name('token.selectGateway');

// PayPal
Route::get('paypal/purchase/{tokenPack}', [PayPalController::class, 'purchase'])->name('paypal.purchaseTokens');
Route::get('paypal/processing', [PayPalController::class, 'processing'])->name('paypal.processing');

// Stripe
Route::get('stripe/purchase/{tokenPack}', [StripeController::class, 'purchase'])->name('stripe.purchaseTokens');
Route::get('stripe/payment-intent/{tokenPack}', [StripeController::class, 'paymentIntent'])->name('stripe.paymentIntent');
Route::get('stripe/order-complete/{tokenSale}', [StripeController::class, 'processOrder'])->name('stripe.processOrder');

Route::get('ccbill/purchase/{tokenPack}', [CCBillController::class, 'purchase'])->name('ccbill.purchaseTokens');

// Bank Transfer
Route::get('bank-transfer/purchase/{tokenPack}', [BankTransferController::class, 'purchase'])->name('bank.purchaseTokens');
Route::post('bank-transfer/request/{tokenPack}', [BankTransferController::class, 'confirmPurchase'])->name('bank.confirmPurchase');
Route::get('bank-transfer/request-processing', [BankTransferController::class, 'requestProcessing'])->name('bank.requestProcessing');

// Categories
Route::get('/browse-channels/{category?}{slug?}', [BrowseChannelsController::class, 'browse'])->name('channels.browse');

Route::get('/dashboard', [HomeController::class, 'redirectToDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Account Settings
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/followings', [ProfileController::class, 'followings'])->name('profile.followings');
Route::get('/my-tokens', [ProfileController::class, 'myTokens'])->name('profile.myTokens');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Payout Settings
Route::get('/withdrawals', [PayoutController::class, 'withdraw'])->name('payout.withdraw');
Route::post('/withdrawals/payout-request/save', [PayoutController::class, 'saveRequest'])->name('payout.saveRequest');
Route::post('/withdrawals/payout-request/cancel', [PayoutController::class, 'cancelRequest'])->name('payout.cancelRequest');
Route::post('/payout/save-settings', [PayoutController::class, 'saveSettings'])->name('payout.saveSettings');

// Subscription
Route::get('/my-subscribers', [SubscriptionController::class, 'mySubscribers'])->name('mySubscribers');
Route::get('/my-subscriptions', [SubscriptionController::class, 'mySubscriptions'])->name('mySubscriptions');
Route::get('/subscribe/channel/{channel}/tier/{tier}', [SubscriptionController::class, 'selectGateway'])->name('subscribe');
Route::get('/subscribe/confirm-subscription/channel/{user}/tier/{tier}', [SubscriptionController::class, 'confirmSubscription'])->name('confirm-subscription');

// Videos
Route::get('/browse-videos/{videocategory?}{slug?}', [VideosController::class, 'browse'])->name('videos.browse');
Route::get('/video/{video}-{slug}', [VideosController::class, 'videoPage'])->name('video.page');
Route::get('/video/unlock/{video}', [VideosController::class, 'unlockVideo'])->name('video.unlock');
Route::post('/video/purchase/{video}', [VideosController::class, 'purchaseVideo'])->name('video.purchase');
Route::post('increase-views/{video}', [VideosController::class, 'increaseViews'])->name('video.increaseViews');
Route::get('/my-videos', [VideosController::class, 'myVideos'])->name('videos.ordered');
Route::get('/videos-manager', [VideosController::class, 'videosManager'])->name('videos.list');
Route::get('/upload-videos', [VideosController::class, 'uploadVideos'])->name('videos.upload');
Route::get('/edit-video/{video}', [VideosController::class, 'editVideo'])->name('videos.edit');
Route::post('/update-video/{video}', [VideosController::class, 'updateVideo'])->name('videos.update');
Route::post('/save', [VideosController::class, 'save'])->name('videos.save');
Route::post('/delete', [VideosController::class, 'delete'])->name('videos.delete');


// Contact
Route::get('/get-in-touch', [ContactController::class, 'form'])->name('contact.form');
Route::post('/get-in-touch/process', [ContactController::class, 'processForm'])->name('contact.process');

// Notifications
Route::get('notifications', [NotificationsController::class, 'inbox'])->name('notifications.inbox');

// Admin login
Route::any('admin/login', [Admin::class, 'login'])->name('admin.login');

// Banned ip
Route::get('banned', [BannedController::class, 'banned'])->name('banned-ip');

// Installer
Route::get('install', [InstallController::class, 'install'])->name('installer')->withoutMiddleware([HandleInertiaRequests::class, BanMiddleware::class]);
Route::get('install/database', [InstallController::class, 'database'])->name('installer.db')->withoutMiddleware([HandleInertiaRequests::class, BanMiddleware::class]);
Route::post('install/save-database', [InstallController::class, 'saveDB'])->name('installer.saveDB')->withoutMiddleware([HandleInertiaRequests::class, BanMiddleware::class]);
Route::get('install/finished', [InstallController::class, 'finished'])->name('installer.finished');

// Pages Routes
Route::get('p/{page}', PageController::class)->name('page');


// Auth Routes (login/register/etc.)
require __DIR__ . '/auth.php';
