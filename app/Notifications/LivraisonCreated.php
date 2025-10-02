<?php

namespace App\Notifications;

use App\Models\Livraison;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LivraisonCreated extends Notification
{
    use Queueable;

    public function __construct(public Livraison $livraison) {}

    public function via($notifiable): array
    {
        // Use database channel to ensure bell notifications always work even if mail is not configured
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $commande = $this->livraison->commande;
        return (new MailMessage)
            ->subject('Nouvelle livraison créée')
            ->greeting('Bonjour '.$notifiable->name)
            ->line('Une nouvelle livraison a été créée pour votre commande #'.$commande->id.'.')
            ->line('Adresse: '.$this->livraison->adresse_livraison)
            ->line('Statut: '.$this->livraison->statut)
            ->action('Voir ma commande', route('front.orders.show', $commande))
            ->line('Merci pour votre confiance.');
    }

    public function toArray($notifiable): array
    {
        return [
            'livraison_id' => $this->livraison->id,
            'commande_id' => $this->livraison->id_commande,
            'adresse' => $this->livraison->adresse_livraison,
            'statut' => $this->livraison->statut,
            'message' => 'Nouvelle livraison créée.'
        ];
    }
}
