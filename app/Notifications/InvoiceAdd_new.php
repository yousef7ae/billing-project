<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceAdd_new extends Notification
{
    use Queueable;
    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }


    public function via($notifiable)
    {
        return ['Database'];
    }

  

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'=>'تم اضافة فاتورة جديدة',
            'userCreate' =>auth()->user()->name,
            'invoice_id' => $this->invoice_id,
        ];
    }
}
