<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Request $request)
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
                    ->replyTo($this->request->email)
                    ->greeting(__('Dear :adminName,', ['adminName' => $notifiable->name]))
                    ->subject(__('New Contact Form Received'))
                    ->line(__(
                        ':name (:email) just sent a message through the contact form',
                        [
                            'name' => $this->request->name,
                            'email' => $this->request->email,
                        ]
                    ))
                    ->line(__(
                        'Subject: :theSubject',
                        [
                            'theSubject' => $this->request->subject
                        ]
                    ))
                    ->line(__(
                        'Message: :theMessage',
                        [
                            'theMessage' => $this->request->message
                        ]
                    ))
                    ->action(__('Admin Panel'), route('admin.dashboard'))
                    ->line(__('Best Regards'));
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
