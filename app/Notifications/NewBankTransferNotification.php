<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewBankTransferNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public User $user, public $proofImage, public $proofDetails, public $tokenPackId)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->attach(Attachment::fromPath(public_path($this->proofImage)))
                    ->replyTo($this->user->email)
                    ->subject(__("New Bank Transfer"))
                    ->line(__("There is a new bank transfer proof from :name (:username)", [
                        'name' => $this->user->name,
                        'username' => $this->user->username
                    ]))
                    ->line(__("Payment proof message: :proofDetails", [
                        'proofDetails' => $this->proofDetails
                    ]))
                    ->line(__("See attachment image for proof!"))
                    ->action(__("Add Token Sale"), route('admin.addTokenSale') . '?user=' . $this->user->id .'&packId=' . $this->tokenPackId);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
