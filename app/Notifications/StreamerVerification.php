<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StreamerVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $document)
    {
        //
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
                    ->attach(Attachment::fromPath(public_path($this->document)))
                    ->replyTo($notifiable->email)
                    ->subject(__("Streamer Verification Request"))
                    ->line(__("New Streamer Identiy Verification Request from :name (:username)", [
                        'name' => $notifiable->name,
                        'username' => '@' . $notifiable->username
                    ]))
                    ->line(__("See attachment image for the verification document!"))
                    ->action(__("Approve Streamer"), route('admin.approveStreamer') . '?user=' . $notifiable->id);
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
