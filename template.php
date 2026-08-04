<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $basePath ?>css/base.css">
    <?php if ($layout === 'vertical'): ?>
        <link rel="stylesheet" href="<?= $basePath ?>css/menu-vertical.css">
    <?php endif; ?>
    <title><?= $title ?></title>
</head>
<body style="flex-direction: <?= $layout === 'vertical' ? 'row' : 'column' ?>;">
    <?php 
      // Layout horizontal: Header + Main + Footer
      if ($layout === 'horizontal') {
        include($basePath . "components/header.php");
        include($basePath . "components/main.php");
        include($basePath . "components/footer.php");
      }
      
      // Layout vertical: Menu + Main
      if ($layout === 'vertical') {
        include($basePath . "components/vertical-menu.php");
        include($basePath . "components/main.php");
      }
    ?>
</body>
</html>