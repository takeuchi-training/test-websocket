<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class NewApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $application;
    private $fromUser;
    private $toUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($application, $fromUser, $toUser)
    {
        $this->application = $application;
        $this->fromUser = $fromUser;
        $this->toUser = $toUser;
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
        $url = url('/admin/applications/' . $this->application->id);

        return (new MailMessage)
                    ->subject('New ' . $this->application->title . ' Application')
                    ->line('Employee ' . $this->fromUser->name . ' just submited a new ' . strtolower($this->application->title) . ' application.')
                    ->line('To user: ' . $notifiable->user->id)
                    ->action('Check application', $url)
                    ->line('Thank you!');
    }

    // /**
    //  * Get the broadcastable representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return BroadcastMessage
    //  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'applicationId' => $this->application->id,
    //         'applicationTitle' => $this->application->title,
    //         'applicationContent' => $this->application->content,
    //         'fromUserName' => $this->fromUser->name,
    //         'toUserId' => $this->toUser->id,
    //     ]);
    // }

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
