<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PasswordReset extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    protected function ResetPassUrl($token)
    {
        $ruta = route('password.reset', ['token' => $token]);

        return $ruta;
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
                ->subject(Lang::get('[SIIEAPP] Reinicio de contraseña'))
                ->line('Has recibido este email porque recibimos una petición para reiniciar la contraseña de tu cuenta.')
                ->action('Reiniciar contraseña', $this->ResetPassUrl($this->token))
                ->line('Si no solicitaste el reinicio de la contraseña, ignora este email.');
    }
}
