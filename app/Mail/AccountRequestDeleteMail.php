<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class AccountRequestDeleteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user.
     *
     * @var \App\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute('backend.account.destroy', now()->addDays(2), ['user' => $this->user->id]);

        return $this->markdown('email.account-request-delete.' . strtolower(locale(true)), compact('url'))
            ->subject(__('Confirma su baja en nuestra plataforma'));
    }
}
