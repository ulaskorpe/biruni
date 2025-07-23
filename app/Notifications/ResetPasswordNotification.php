<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Şifre değişiklik talebi')
        ->line('Sitemizden bu e-posta hesabı ile şifre değişiklik talebi oluşturuldu. Şifrenizi değiştirmek için aşağıdaki butona tıklayabilirsiniz.')
        ->action('Şifremi değiştir', url('reset-password', $this->token))
        ->line('Şifre değişikliği talebinde bulunmadıysanız lütfen bu e-postayı dikkate almayın.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
