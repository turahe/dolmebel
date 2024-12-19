<?php

declare(strict_types=1);

namespace App\Notifications\Users;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user) {}

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
            ->subject(__('Your Password Has Been Successfully Changed'))
            ->line(__('We wanted to let you know that the password for your account was successfully changed on ', ['date' => $notifiable->updated_at]))
            ->line(__('If you did not request this change, please contact our support team immediately to secure your account. You can also reset your password'))
            ->action(__('Click Here'), config('app.frontend_url').'/reset-password')
            ->line(__('If you did make this change, you don’t need to do anything further. If you encounter any issues accessing your account, please don’t hesitate to reach out to us.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }
}
