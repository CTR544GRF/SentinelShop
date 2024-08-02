<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Factura;
use App\Models\User;

class FacturaMailV2 extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $factura;
    public $usuario;
    public $fianzaNuFianzas;

    /**
     * Create a new message instance.
     *
     * @param string $pdf
     * @param Factura $factura
     * @param User $usuario
     * @param array $fianzaNuFianzas
     */
    public function __construct($pdf, Factura $factura, User $usuario, array $fianzaNuFianzas)
    {
        $this->pdf = $pdf;
        $this->factura = $factura;
        $this->usuario = $usuario;
        $this->fianzaNuFianzas = $fianzaNuFianzas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.factura_v2')
            ->attachData($this->pdf, 'factura.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
    
}