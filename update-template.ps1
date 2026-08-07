# Script update-template.ps1 (PowerShell sur Windows) pour mettre à jour template-web-app

param(
    # Source: Le fichier contenant les variables à copier
    [string]$File1 = "template-web-app/config.json",

    # Destination: Le fichier qui recevra les nouvelles variables
    [string]$File2 = "config.json"
)

# # Mise à jour du template-web-app depuis le dépôt GitHub (ou ajout du template)
if (Test-Path template-web-app) {
    Remove-Item -Recurse -Force template-web-app
}
git clone https://github.com/Val648/template-web-app.git template-web-app

# Mise à jour ou ajout du config.json
if (Test-Path config.json) {
    # Ajout des nouveautés du template
    # Comparer les 2 fichiers et ajouter les nouveautés du config.json du template dans le config.json existant
    # ==============================================================================
    # SCRIPT DE FUSION UNIDIRECTIONNELLE DE FICHIERS JSON (VERSION SIMPLE)
    # ==============================================================================
    # Ce script FUSIONNE les variables manquantes DANS UN SEUL SENS:
    #   - File1 → File2 uniquement
    #   - Les variables de File1 qui manquent dans File2 sont ajoutées
    #   - MAIS File2 ne modifie PAS File1
    #
    # ⚠️  DIFFÉRENCE IMPORTANTE AVEC LE SCRIPT COMPLET:
    #   - Script complet: BIDIRECTIONNEL (modification des 2 fichiers)
    #   - Ce script:      UNIDIRECTIONNEL (modification de File2 seulement)
    #   - Script complet: Paramètres en ligne de commande
    #   - Ce script:      Chemins codés en dur (plus rapide, moins flexible)
    #
    # Usage: .\compare-json-simple.ps1 -File1 "config1.json" -File2 "config2.json"
    # ==============================================================================

    # --- CHARGEMENT DES FICHIERS JSON ---
    # ConvertFrom-Json transforme le texte JSON en objet PowerShell
    # on peut alors manipuler les propriétés et les valeurs

    Write-Host "Chargement des fichiers JSON..." -ForegroundColor Cyan

    # Charger File1 (source des variables à ajouter)
    $json1 = Get-Content $File1 -Raw | ConvertFrom-Json
    Write-Host "  ✓ Fichier 1 (source): $File1" -ForegroundColor Yellow

    # Charger File2 (destination qui sera modifié)
    $json2 = Get-Content $File2 -Raw | ConvertFrom-Json
    Write-Host "  ✓ Fichier 2 (destination): $File2" -ForegroundColor Yellow

    # ==============================================================================
    # FONCTION: Merge-Objects
    # ==============================================================================
    # Parcourt toutes les propriétés de 'source' et les ajoute à 'target'
    # si elles manquent. Gère les objets imbriqués par récursion.
    #
    # Paramètres:
    #   - $source:  L'objet JSON source (File1)
    #   - $target:  L'objet JSON destination à modifier (File2)
    # ==============================================================================

    function Merge-Objects {
        param(
            [object]$source,    # Objet source: celui qui a les variables
            [object]$target     # Objet cible: celui qui reçoit les variables
        )
        
        # PSObject.Properties donne la liste de toutes les propriétés
        # ForEach-Object permet d'itérer sur chacune d'elles
        $source.PSObject.Properties | ForEach-Object {
            
            # Récupérer le nom et la valeur de la propriété actuelle
            $name = $_.Name                    # Nom de la propriété (ex: "app", "version")
            $sourceValue = $_.Value            # Valeur dans le source (ex: { ... })
            $targetValue = $target.$name       # Valeur dans le target (ex: $null si absent)
            
            # CONDITION 1: La propriété n'existe pas dans le target ($null)
            if ($null -eq $targetValue) {
                
                # ✓ Ajouter cette propriété au target avec sa valeur complète
                $target | Add-Member -MemberType NoteProperty -Name $name -Value $sourceValue -Force
                Write-Host "  ✓ Ajouté: $name" -ForegroundColor Green
            }
            
            # CONDITION 2: La propriété existe MAIS c'est un objet imbriqué
            # Dans ce cas, on doit vérifier les sous-propriétés
            elseif ($sourceValue -is [PSCustomObject] -and $targetValue -is [PSCustomObject]) {
                
                # Afficher qu'on parcourt un sous-objet
                Write-Host "  → Vérification des sous-propriétés: $name" -ForegroundColor Cyan
                
                # Appel RÉCURSIF: explorer les propriétés imbriquées
                # Cela permet de gérer app.database.host, app.database.port, etc.
                Merge-Objects -source $sourceValue -target $targetValue
            }
        }
    }

    # ==============================================================================
    # EXÉCUTION DE LA FUSION
    # ==============================================================================

    Write-Host "`n" + ("="*60) -ForegroundColor Magenta
    Write-Host "FUSION UNIDIRECTIONNELLE: $File1 → $File2" -ForegroundColor Magenta
    Write-Host "="*60 -ForegroundColor Magenta

    # Lancer la fusion (File1 source → File2 destination)
    Write-Host "`nRecherche des variables manquantes..." -ForegroundColor Cyan
    Merge-Objects -source $json1 -target $json2

    # ==============================================================================
    # SAUVEGARDE DU RÉSULTAT
    # ==============================================================================

    Write-Host "`nSauvegarde du fichier..." -ForegroundColor Cyan

    # Convertir l'objet modifié en JSON et le sauvegarder
    # ConvertTo-Json transforme l'objet PowerShell en texte JSON
    # -Depth 10 permet de gérer les objets imbriqués jusqu'à 10 niveaux
    $json2 | ConvertTo-Json -Depth 10 | Set-Content $File2 -Encoding UTF8

    Write-Host "✓ Fichier sauvegardé: $File2" -ForegroundColor Green

    # ==============================================================================
    # AFFICHAGE DU RÉSULTAT
    # ==============================================================================

    Write-Host "`n" + ("="*60) -ForegroundColor Yellow
    Write-Host "📄 Contenu du fichier après fusion:" -ForegroundColor Yellow
    Write-Host "="*60 -ForegroundColor Yellow
    Get-Content $File2
}
else {
    # Copie du config.json à la racine
    Copy-Item template-web-app\config.json config.json
}

# Suppression des éléments inutiles du template
Remove-Item -Recurse -Force template-web-app\.git
Remove-Item -Recurse -Force template-web-app\config.json
Remove-Item -Recurse -Force template-web-app\update-template.ps1