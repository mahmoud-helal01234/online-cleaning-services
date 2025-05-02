<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $items;
    public $discountValue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $items,$discountValue)
    {
        $this->order = $order;
        $this->items = $items;
        $this->discountValue = $discountValue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order Received')
                    ->view('emails.newOrderNotification')
                    ->with([
                        'order' => $this->order,
                        'items' => $this->items,
                        'discountValue' => $this->discountValue
                    ]);
    }
}
