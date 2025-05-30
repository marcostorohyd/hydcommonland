<?php

namespace App\Notifications;

use App\Directory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DirectoryChangeRequest extends Notification
{
    use Queueable;

    /**
     * Directory.
     *
     * @var \App\Directory
     */
    private $directory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Directory $directory)
    {
        $this->directory = $directory;
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
        return (new MailMessage)
            ->subject(__('Solicitud cambio de datos en directorio.'))
            ->line(__('Un/a usuario/a ha solicitado un cambio de datos.'))
            ->action(__('Ver datos del directorio'), route('backend.directory.edit', $this->directory->id));
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
