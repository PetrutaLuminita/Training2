<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;
    private $customer, $email, $comments, $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $customer, $email, $comments)
    {
        $this->customer = $customer;
        $this->email = $email;
        $this->comments = $comments;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Order')
                    ->markdown('products.send_email')
                    ->with([
                        'customer' => $this->customer,
                        'email' => $this->email,
                        'comments' => $this->comments,
                        'products' => $this->products
                    ]);
    }
}
