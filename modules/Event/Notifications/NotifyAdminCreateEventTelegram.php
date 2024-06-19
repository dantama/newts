<?php

namespace Modules\Event\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class NotifyAdminCreateEventTelegram extends Notification
{

    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arr)
    {
        $this->data = $arr;
    }


    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
                ->content('Halo Admin!'.PHP_EOL.'Berikut informasi pengajuan event baru.'.PHP_EOL.'Nama Event : '.$this->data['name'].'.'.PHP_EOL.'Diajukan Oleh : '.$this->data['management'].'.'.PHP_EOL.'Waktu : '. $this->data['start_at']. ' s.d. ' . $this->data['end_at'].'.'.PHP_EOL.'Biaya : Rp. ' . $this->data['price'].'.'.PHP_EOL.'Mohon untuk segera ditindaklajuti pengajuan event tersebut.'.PHP_EOL.'Terimakasih atas perhatiannya.');
    }
}