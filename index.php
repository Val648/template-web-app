<?php

// Déterminer le layout (passer en paramètre ou variable)
$layout = isset($_GET['layout']) ? $_GET['layout'] : 'horizontal';
// Valeurs acceptées: 'horizontal' ou 'vertical'
$layout = in_array($layout, ['horizontal', 'vertical']) ? $layout : 'horizontal';

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';
$page = in_array($page, ['accueil', 'utilisateurs']) ? $page : 'accueil';

$appName = "Application";
$title = $appName . ($layout === 'vertical' ? ' - Admin' : ' - Accueil');
$navigation = [
    ['label' => 'Accueil', 'icon' => '📊', 'page' => 'accueil'],
    ['label' => 'Utilisateurs', 'icon' => '👥', 'page' => 'utilisateurs'],
    ['label' => 'Paramètres', 'icon' => '⚙️', 'page' => 'parametres'],
    ['label' => 'Analytiques', 'icon' => '📈', 'page' => 'analytics'],
    ['label' => 'Rapports', 'icon' => '📄', 'page' => 'reports'],
    // ['label' => 'Quitter', 'icon' => '🚪', 'page' => 'index.php'],
];

$basePath = "template/";

include("template.php");