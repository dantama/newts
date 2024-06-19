<?php

namespace Modules\Event\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyAdminCreateEvent extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $ev = $this->data ?? '';

        return (new MailMessage)
                    ->subject('Pemberitahuan Pengajuan Event Baru oleh '.$ev['management'])
                    ->greeting('Halo Admin')
                    ->line('Berikut informasi pengajuan event baru.')
                    ->line('Nama Event : '.$ev['name'])
                    ->line('Diajukan Oleh : '.$ev['management'])
                    ->line('Waktu : '.$ev['start_at'].' s.d. '.$ev['end_at'])
                    ->line('Biaya : Rp. '.$ev['price'])
                    ->line('Mohon untuk segera ditindaklajuti pengajuan tersebut.')
                    ->line('Terimakasih atas perhatiannya.')
                    ->action('Masuk', 'https://admin.tapaksuciapp.xyz');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
