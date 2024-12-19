<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $type)
    {
        //
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
        $type = match ($this->type) {
            'username' => $notifiable->username,
            'email' => $notifiable->email,
            'password' => '****',
            'phone' => $notifiable->phone,
        };

        $url = config('app.frontend_url').'/account/security';

        return (new MailMessage)
            ->subject(__('Your Account Information Has Been Updated'))
            ->line(__('Hello ', ['username' => $notifiable->username]))
            ->line(__('We wanted to inform you that changes were recently made to your account information. Specifically, your username and/or password was updated on :date', ['date' => $notifiable->updated_at->toDateTimeString()]))
            ->line(__('Account Details:'))
            ->line($this->type.': '.$type)
            ->line(__('Date and Time of Change: :date', ['date' => $notifiable->updated_at->toDateTimeString()]))
            ->line(__('If you did not authorize these changes, please secure your account by resetting your password.'))
            ->action(__('Click here'), $url)
            ->line(__('or contacting our support team immediately.'))
            ->line(__('If you made these changes, no further action is needed. For any questions or additional assistance, feel free to reach out.'))
            ->line(__('Thank you for helping keep your account secure.'));
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
