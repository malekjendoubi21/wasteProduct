<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statut de votre demande</title>
</head>
<body>
    <h2>Bonjour {{ $demande->nom_organisation }},</h2>

    @if($statut === 'accepte')
        <p>Félicitations 🎉 ! Votre demande de partenariat a été <strong>acceptée</strong>.</p>
        <p>Voici vos informations de connexion :</p>
        <ul>
            <li><strong>Email :</strong> {{ $demande->email_contact }}</li>
            <li><strong>Mot de passe temporaire :</strong> {{ $password }}</li>
        </ul>
        <p>👉 Nous vous recommandons de changer ce mot de passe dès votre première connexion pour plus de sécurité.</p>
    @else
        <p>Nous vous remercions pour votre demande de partenariat.</p>
        <p>Malheureusement, après étude de votre dossier, votre demande a été <strong>refusée</strong>.</p>
        <p>Vous pouvez nous recontacter pour une éventuelle collaboration future.</p>
    @endif

    <br>
    <p>Cordialement,<br>L’équipe WasteProduct</p>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? 'Statut de votre demande - EcoCycle' }}</title>
</head>
<body>
    <h2>{{ $subject ?? 'Statut de votre demande de partenariat' }}</h2>
    <p>Bonjour {{ $demande->nom_organisation }},</p>

    @if($statut === 'accepte')
        <p>Félicitations ! Votre demande de partenariat a été acceptée.</p>
        <p>Votre compte a été créé avec les identifiants suivants :</p>
        <ul>
            <li><strong>Email :</strong> {{ $demande->email_contact }}</li>
            <li><strong>Mot de passe temporaire :</strong> {{ $password }}</li>
        </ul>
        <p>Veuillez vous connecter à notre plateforme pour finaliser votre inscription. <a href="{{ url('/login') }}">Cliquez ici</a>.</p>
    @elseif($statut === 'refuse')
        <p>Nous regrettons de vous informer que votre demande de partenariat a été refusée.</p>
        <p>Pour plus d'informations, contactez-nous à {{ $demande->email_contact }}.</p>
    @elseif($statut === 'test')
        <p>Ceci est un email de test pour vérifier la configuration SMTP.</p>
        <p>Votre email {{ $demande->email_contact }} a été utilisé avec succès. Le mot de passe fictif est : {{ $password }} (non valide).</p>
        <p>Si vous recevez ce message, la configuration fonctionne correctement !</p>
    @else
        <p>Statut inconnu. Veuillez contacter le support.</p>
    @endif

    <p>Cordialement,<br>L'équipe EcoCycle</p>
</body>
</html>