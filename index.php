<?php

$textPath = "config.json";

// Get content from JSON file
$basePath = getJsonContent($textPath, "templatePath") ?? "";
$pagePath = getJsonContent($textPath, "pagePath") ?? "views/";
$cssPath = getJsonContent($textPath, "cssPath") ?? "css/";
$jsPath = getJsonContent($textPath, "jsPath") ?? "js/";
$appName = getJsonContent($textPath, "appName") ?? "Mon application"; 
$layout = getJsonContent($textPath, "layout") ?? "horizontal";
$layout = in_array($layout, ['horizontal', 'vertical']) ? $layout : 'horizontal';
$navigation = getJsonContent($textPath, "navigation");

// Dynamic variables
$page ??= $_GET["page"] ?? 'default';
$title ??= $appName . ($layout === 'vertical' ? ' - Admin' : ' - Accueil');

function getJsonContent($textPath, $key) : string|array|null {
    $jsonData = json_decode(file_get_contents($textPath), true);
    return isset($jsonData[$key]) ? $jsonData[$key] : null;
}

include("template.php");