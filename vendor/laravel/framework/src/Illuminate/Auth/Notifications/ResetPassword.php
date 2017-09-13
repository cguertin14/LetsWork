<?php

namespace Illuminate\Auth\Notifications;

use App\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('support@letswork.dev')
            ->subject('Réinitialisation du mot de passe')
            ->line('vous pouvez réinitialiser votre mot de passe allant sur le lien suivant: ')
            ->action('Réinitialiser le mot de passe', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Si vous n\'avez pas fait de demande pour réinitialiser votre mot de passe, aucune autre action n\'est nécessaire.');
    }
}
