<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $factura;
    public $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdfContent, $factura, $usuario)
    {
        $this->pdfContent = $pdfContent;
        $this->factura = $factura;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails') //nombre de la vista en la carpeta views
                    ->subject('Factura de Pago')
                    ->attachData($this->pdfContent, 'factura.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}