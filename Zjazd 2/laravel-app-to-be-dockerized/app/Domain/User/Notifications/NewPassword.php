<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:49
 */

namespace App\Domain\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class NewPassword extends Notification
{
    use Queueable;

    public function __construct(private string $password)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line(Lang::get('Here is your new password, now You can log in'))
            ->subject(Lang::get('New password'))
            ->greeting($this->password);
    }
}
