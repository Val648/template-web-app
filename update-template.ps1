# Script update-template.ps1 (PowerShell sur Windows) pour mettre à jour template-web-app
if (Test-Path template-web-app) {
    Remove-Item -Recurse -Force template-web-app
}
git clone https://github.com/Val648/template-web-app.git template-web-app
Remove-Item -Recurse -Force template-web-app\.git