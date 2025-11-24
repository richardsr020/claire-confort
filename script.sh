#!/bin/bash

# Script de création de structure pour Claire Confort
# Basé sur l'arborescence fournie

echo "Création de la structure pour Claire Confort..."

# Création des dossiers principaux
mkdir -p claire
cd claire

# Création des sous-dossiers
mkdir -p uploads/products
mkdir -p assets/{css,js,images}
mkdir -p app
mkdir -p views
mkdir -p data/sqlite

# Création des fichiers PHP dans app/
touch app/auth.php
touch app/product-manager.php
touch app/dashboard.php
touch app/config.php
touch app/admin-login.php
touch app/db.php

# Création des views
touch views/products.php
touch views/home.php
touch views/dashboard.php

# Création des assets
touch assets/css/style.css
touch assets/js/main.js
touch assets/js/dashboard.js

# Création des autres fichiers
touch index.php
touch .htaccess
touch README.md
touch data/sqlite/claire_confort.db

# Création du script lui-même (optionnel)
touch script.sh

echo "Structure créée avec succès!"
echo ""
echo "Arborescence créée:"
find . -type f | sort
