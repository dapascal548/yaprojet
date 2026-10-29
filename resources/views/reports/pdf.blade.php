<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESPRO - Rapport Mensuel {{ $month }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1e293b; background: #ffffff; margin: 0; padding: 0; font-size: 11px; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px; }
        .header-title { font-size: 22px; font-weight: 800; color: #1e293b; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .header-subtitle { font-size: 11px; font-weight: 700; color: #2563eb; text-transform: uppercase; margin-top: 3px; }
        .meta-info { text-align: right; font-size: 10px; color: #64748b; }

        .kpi-container { display: table; width: 100%; table-layout: fixed; border-spacing: 10px; margin-bottom: 20px; }
        .kpi-card { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center; }
        .kpi-label { font-size: 9px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 4px; }
        .kpi-value { font-size: 16px; font-weight: 800; color: #0f172a; }
        .kpi-value-accent { color: #2563eb; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #f1f5f9; border-bottom: 2px solid #cbd5e1; font-size: 9px; font-weight: 800; text-transform: uppercase; color: #475569; padding: 8px 10px; text-align: left; }
        td { border-bottom: 1px solid #e2e8f0; padding: 8px 10px; color: #334155; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }

        .amount { font-weight: 700; text-align: right; color: #0f172a; }
        .footer { margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 10px; text-align: center; font-size: 9px; color: #94a3b8; }

        /* Boutons d'impression cachés lors de l'impression */
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: #fff; }
            .kpi-card { border: 1px solid #ccc; }
        }
        .no-print-bar { background: #0f172a; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-radius: 8px; }
        .btn-print { background: #10b981; color: white; border: none; padding: 8px 16px; font-weight: bold; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>

    <!-- Barre d'action d'impression (Masquée à l'impression) -->
    <div class="no-print no-print-bar">
        <span>Aperçu de l'export PDF du rapport mensuel (Mois : <strong>{{ $month }}</strong>)</span>
        <button onclick="window.print()" class="btn-print">Enregistrer / Imprimer en PDF</button>
    </div>

    <!-- En-tête Officiel du Rapport -->
    <div class="header">
        <div>
            <h1 class="header-title">GESPRO - Rapport Mensuel</h1>
            <div class="header-subtitle">Bilan Comptable & Audit des Dépenses - Mois : {{ $month }}</div>
        </div>
        <div class="meta-info">
            <strong>Généré le :</strong> {{ date('d/m/Y H:i') }}<br>
            <strong>Émetteur :</strong> {{ auth()->user()->name ?? 'Administrateur' }}<br>
            <strong>Statut :</strong> Document Officiel Validé
        </div>
    </div>

    <!-- Synthèse Chiffrée (KPIs) -->
    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-label">Dépenses Validées du Mois</div>
            <div class="kpi-value kpi-value-accent">{{ number_format($totalDepensesMois, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Mois Précédent (M-1)</div>
            <div class="kpi-value">{{ number_format($totalDepensesMoisPrecedent, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Évolution Mensuelle</div>
            <div class="kpi-value" style="color: {{ $evolutionDepenses <= 0 ? '#10b981' : '#f43f5e' }}">
                {{ $evolutionDepenses > 0 ? '+' : '' }}{{ number_format($evolutionDepenses, 1) }} %
            </div>
        </div>
    </div>

    <!-- Tableau Détaillé des Dépenses -->
    <h3 style="font-size: 12px; font-weight: 800; color: #1e293b; margin-top: 20px; border-left: 3px solid #2563eb; padding-left: 8px;">
        1. Détail des Dépenses Validées
    </h3>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Projet</th>
                <th>Catégorie de Charge</th>
                <th>Description / Motif</th>
                <th>Déclaré par</th>
                <th style="text-align: right;">Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @forelse($depensesMois as $depense)
            <tr>
                <td>{{ $depense->date }}</td>
                <td><strong>{{ $depense->projet->nom ?? 'N/A' }}</strong></td>
                <td>{{ $depense->categorie->nom ?? 'N/A' }}</td>
                <td>{{ $depense->description }}</td>
                <td>{{ $depense->user->name ?? 'N/A' }}</td>
                <td class="amount">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">
                    Aucune dépense validée pour ce mois.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($depensesMois->count() > 0)
        <tfoot>
            <tr style="background: #f1f5f9; font-weight: bold;">
                <td colspan="5" style="text-align: right; font-size: 11px; padding: 10px;">TOTAL CUMULÉ DU MOIS :</td>
                <td class="amount" style="font-size: 12px; color: #2563eb; padding: 10px;">{{ number_format($totalDepensesMois, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        Document d'audit financier extrait du système d'information GESPRO &bull; Page 1/1
    </div>

    <!-- Script de lancement automatique de l'impression PDF si ouvert seul -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
