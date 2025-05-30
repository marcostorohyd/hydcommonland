<?php

namespace App\Notifications;

use App\Directory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification
{
    use Queueable;

    /**
     * User.
     *
     * @var \App\User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $directory = Directory::withoutGlobalScopes()
            ->where('user_id', $this->user->id)
            ->first();

        return (new MailMessage)
            ->subject(__('Usuario/a pendiente de aprobación'))
            ->line(__('Un/a nuevo/a usuario/a se ha registrado'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->action(__('Ver datos de usuario'), route('backend.directory.edit', $directory->id));
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
