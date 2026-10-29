<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposition Commerciale / Devis Estimatif</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e2e8f0; }
        .header { text-align: center; padding-bottom: 24px; border-bottom: 2px solid #f1f5f9; }
        .title { color: #2563eb; font-size: 20px; font-weight: 800; margin: 8px 0 0 0; }
        .subtitle { color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
        .content { margin-top: 24px; font-size: 14px; line-height: 1.6; }
        .devis-box { background-color: #f8fafc; border-radius: 12px; padding: 20px; margin: 20px 0; border: 1px solid #cbd5e1; }
        .devis-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; font-size: 13px; }
        .devis-row:last-child { border-bottom: none; font-weight: bold; font-size: 16px; color: #2563eb; padding-top: 14px; }
        .footer { text-align: center; margin-top: 32px; font-size: 11px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="subtitle">GESTION DE PROJETS - GESPRO</div>
            <h1 class="title">Proposition Commerciale & Devis</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $projet->client }}</strong>,</p>

            <p>Nous avons le plaisir de vous transmettre le devis estimatif initial concernant l'ouverture de votre projet <strong>« {{ $projet->nom }} »</strong>.</p>

            <p><strong>Description du projet :</strong><br>
            {{ $projet->description ?? 'Aucune description spécifique renseignée.' }}</p>

            <p><strong>Dates prévisionnelles :</strong> Du {{ $projet->date_debut }} au {{ $projet->date_fin_prevue }}</p>

            <div class="devis-box">
                <div style="font-weight: bold; margin-bottom: 12px; color: #334155;">Détail du Devis Estimatif Initial :</div>

                @if($projet->devis)
                <div class="devis-row">
                    <span>Main d'œuvre :</span>
                    <span>{{ number_format($projet->devis->main_oeuvre, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="devis-row">
                    <span>Matériel & Équipements :</span>
                    <span>{{ number_format($projet->devis->materiel, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="devis-row">
                    <span>Transport & Logistique :</span>
                    <span>{{ number_format($projet->devis->transport, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="devis-row">
                    <span>Autres Coûts / Divers :</span>
                    <span>{{ number_format($projet->devis->autres_couts, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="devis-row">
                    <span>Montant Total Estimatif :</span>
                    <span>{{ number_format($projet->devis->montant_total, 0, ',', ' ') }} FCFA</span>
                </div>
                @else
                <p>Devis en cours de finalisation.</p>
                @endif
            </div>

            <p>Nous restons à votre entière disposition pour tout renseignement complémentaire.</p>
            <p>Cordialement,<br><strong>L'équipe GESPRO</strong></p>
        </div>

        <div class="footer">
            Cet email a été généré automatiquement par le système d'information GESPRO.
        </div>
    </div>
</body>
</html>
