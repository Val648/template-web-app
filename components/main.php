<main>
    <?php if($layout === 'vertical') : ?>
        <section class="first-section">
            <h2>Bienvenue sur <?= $appName ?></h2>
            <a href="index.php?page=<?= $page ?>">Chemin</a>
        </section>
    <?php endif; ?>
    <?php
        if (file_exists($pagePath . $page . ".php")) {
            include($pagePath . $page . ".php");
        }
        else {
            include($basePath . "views/default.php");
        }
    ?>
</main>