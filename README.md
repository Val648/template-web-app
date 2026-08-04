# Template pour applications web

## Actions à réaliser :
- Copier le text.json à la racine de son projet et de l'adapter pour correspondre à vos besoins
- Copier le fichier update-template.ps1 pour ajouter où mettre à jour le template-web-app

## Ajouter le template à son projet GitHub par script PowerShell :
```
if (Test-Path template-web-app) {
    Remove-Item -Recurse -Force template-web-app
}
git clone https://github.com/Val648/template-web-app.git template-web-app
Remove-Item -Recurse -Force template-web-app\.git
```