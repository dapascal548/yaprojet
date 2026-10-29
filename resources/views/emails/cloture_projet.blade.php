<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notification de Clôture de Projet</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e2e8f0; }
        .header { text-align: center; padding-bottom: 24px; border-bottom: 2px solid #f1f5f9; }
        .title { color: #059669; font-size: 20px; font-weight: 800; margin: 8px 0 0 0; }
        .subtitle { color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
        .content { margin-top: 24px; font-size: 14px; line-height: 1.6; }
        .success-badge { display: inline-block; background-color: #ecfdf5; color: #047857; padding: 6px 14px; border-radius: 9999px; font-weight: bold; font-size: 12px; margin-bottom: 16px; border: 1px solid #a7f3d0; }
        .info-box { background-color: #f8fafc; border-radius: 12px; padding: 20px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .footer { text-align: center; margin-top: 32px; font-size: 11px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="subtitle">GESTION DE PROJETS - GESPRO</div>
            <div class="success-badge">PROJET CLÔTURÉ & LIVRÉ</div>
            <h1 class="title">Achevement du Projet</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $projet->client }}</strong>,</p>

            <p>Nous avons le plaisir de vous informer que le projet <strong>« {{ $projet->nom }} »</strong> a été officiellement <strong>clôturé et achevé avec succès</strong>.</p>

            <div class="info-box">
                <p style="margin:0 0 8px 0;"><strong>Récapitulatif de livraison :</strong></p>
                <p style="margin:4px 0;"><strong>Client :</strong> {{ $projet->client }}</p>
                <p style="margin:4px 0;"><strong>Date de Début :</strong> {{ $projet->date_debut }}</p>
                <p style="margin:4px 0;"><strong>Date de Clôture Réelle :</strong> {{ $projet->date_fin_reelle ?? date('Y-m-d') }}</p>
                <p style="margin:4px 0;"><strong>Statut actuel :</strong> Clôturé (Terminé)</p>
            </div>

            <p>Nous vous remercions pour la confiance accordée au cours de la réalisation de ce projet.</p>
            <p>Cordialement,<br><strong>L'équipe GESPRO</strong></p>
        </div>

        <div class="footer">
            Cet email de confirmation a été transmis automatiquement via le système d'information GESPRO.
        </div>
    </div>
</body>
</html>
