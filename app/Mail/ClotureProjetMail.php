<?php

namespace App\Mail;

use App\Models\Projet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClotureProjetMail extends Mailable
{
    use Queueable, SerializesModels;

    public Projet $projet;

    public function __construct(Projet $projet)
    {
        $this->projet = $projet;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "GESPRO - Notification de Clôture et Livraison du Projet : {$this->projet->nom}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cloture_projet',
        );
    }
}
