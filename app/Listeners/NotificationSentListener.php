<?php

namespace App\Listeners;

use App\Notifications\NewBankTransferNotification;
use App\Notifications\StreamerVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotificationSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->notification instanceof StreamerVerification) {
            unlink(public_path($event->notification->document));
        } elseif ($event->notification instanceof NewBankTransferNotification) {
            unlink(public_path($event->notification->proofImage));
        }
    }
}
