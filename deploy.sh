
#!/usr/bin/env bash
set -e

echo "=== Preparation GESPRO sur alwaysdata ==="

# Vérifier le fichier d'environnement
if [ ! -f .env ]; then
    echo "ERREUR : fichier .env absent."
    echo "Configurez .env avant de continuer."
    exit 1
fi

# Vérifier la présence de Composer
if [ ! -f composer.json ]; then
    echo "ERREUR : composer.json absent."
    exit 1
fi

# Installer les dépendances
composer install --no-dev --optimize-autoloader --no-interaction

# Préparer les dossiers Laravel
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Vider les anciens caches
php artisan optimize:clear

# Générer les caches de production
php artisan config:cache
php artisan view:cache

echo "=== Preparation terminee ==="
echo "Verifier APP_KEY, la base MySQL et les permissions."
echo "Aucune migration ni seeder n'a ete execute."
