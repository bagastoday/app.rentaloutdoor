<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi reset password KHUSUS customer.
 * Beda dari notifikasi bawaan Laravel karena link-nya harus mengarah
 * ke route customer ('customer.password.reset'), bukan route admin
 * bawaan Breeze ('password.reset').
 */
class CustomerResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url(route('customer.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password Akun Rental Outdoor')
            ->line('Kamu menerima email ini karena kami menerima permintaan reset password untuk akunmu.')
            ->action('Reset Password', $url)
            ->line('Link ini berlaku selama 60 menit.')
            ->line('Kalau kamu tidak meminta reset password, abaikan saja email ini.');
    }
}