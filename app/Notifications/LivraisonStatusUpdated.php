<?php

namespace App\Notifications;

use App\Models\Livraison;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LivraisonStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Livraison $livraison) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $commande = $this->livraison->commande;
        $isEnCours = $this->livraison->statut === 'en_cours' || $this->livraison->statut === 'en-cours';
        $subject = $isEnCours ? 'Votre commande est en cours d\'expédition' : 'Mise à jour du statut de la livraison';
        $line = $isEnCours
            ? 'Votre commande #'.$commande->id.' est en cours d\'expédition vers votre adresse.'
            : 'Le statut de votre livraison pour la commande #'.$commande->id.' a été mis à jour.';
        return (new MailMessage)
            ->subject($subject)
            ->greeting('Bonjour '.$notifiable->name)
            ->line($line)
            ->line('Nouveau statut: '.$this->livraison->statut)
            ->action('Voir ma commande', route('front.orders.show', $commande))
            ->line('Merci pour votre confiance.');
    }

    public function toArray($notifiable): array
    {
        $isEnCours = $this->livraison->statut === 'en_cours' || $this->livraison->statut === 'en-cours';
        return [
            'livraison_id' => $this->livraison->id,
            'commande_id' => $this->livraison->id_commande,
            'statut' => $this->livraison->statut,
            'message' => $isEnCours ? 'Votre commande est en cours d\'expédition.' : 'Statut de livraison mis à jour.'
        ];
    }
}
