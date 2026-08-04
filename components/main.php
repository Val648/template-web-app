<main>
    <section class="first-section">
        <h2>Bienvenue sur <?= $appName ?></h2>
        <a href="index.php?layout=horizontal&page=<?= $page ?>">Layout horizontal</a>
        <a href="index.php?layout=vertical&page=<?= $page ?>">Layout vertical</a>
    </section>
    <?php include($basePath . "pages/" . $page . ".php") ?>
</main>