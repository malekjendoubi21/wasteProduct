<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandePartenariatStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $password;
    public $statut;

    /**
     * Create a new message instance.
     */
    public function __construct($demande, $statut, $password = null)
    {
        $this->demande = $demande;
        $this->statut = $statut;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Définir le sujet dynamiquement
        $subject = 'Statut de votre demande de partenariat';
        if ($this->statut === 'accepte') {
            $subject = 'Votre demande de partenariat a été acceptée';
        } elseif ($this->statut === 'refuse') {
            $subject = 'Votre demande de partenariat a été refusée';
        } elseif ($this->statut === 'test') {
            $subject = 'Test de configuration email - EcoCycle';
        }

        return $this->subject($subject)
                    ->view('emails.demande_partenariat_status')
                    ->with([
                        'demande' => $this->demande,
                        'statut' => $this->statut,
                        'password' => $this->password,
                        'subject' => $subject,
                    ]);
    }
}