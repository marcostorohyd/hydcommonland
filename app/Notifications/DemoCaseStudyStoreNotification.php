<?php

namespace App\Notifications;

use App\DemoCaseStudy;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DemoCaseStudyStoreNotification extends Notification
{
    use Queueable;

    /**
     * The DemoCaseStudy.
     *
     * @var \App\DemoCaseStudy
     */
    private $demo;

    /**
     * Create a new notification instance.
     *
     * @param  \App\DemoCaseStudy  $demo
     * @return void
     */
    public function __construct(DemoCaseStudy $demo)
    {
        $this->demo = $demo;
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
            ->subject(__('Caso demostrativo pendiente de aprobación.'))
            ->line(__('Un nuevo caso demostrativo se ha creado.'))
            ->action(__('Ver datos del caso demostrativo'), route('backend.demo.edit', $this->demo->id));
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
