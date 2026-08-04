<menu>
    <div id="title">
        <h1><?= $appName ?></h1>
        <button id="toggle-menu" title="Rétracter le menu">✕</button>
    </div>
    <?php include($basePath . "components/navigation.php") ?>
</menu>

<script>
document.getElementById('toggle-menu').addEventListener('click', function() {
    const main = document.querySelector('main');
    main.classList.toggle('collapsed');
    
    const menu = document.querySelector('menu');
    menu.classList.toggle('collapsed');
    
    // Sauvegarder l'état dans le localStorage
    const isCollapsed = menu.classList.contains('collapsed');
    localStorage.setItem('menu-collapsed', isCollapsed);
    
    // Changer l'icône
    this.textContent = isCollapsed ? '☰' : '✕';
});

// Restaurer l'état du menu au chargement
document.addEventListener('DOMContentLoaded', function() {
    const isCollapsed = localStorage.getItem('menu-collapsed') === 'true';
    const main = document.querySelector('main');
    const menu = document.querySelector('menu');
    const toggleBtn = document.getElementById('toggle-menu');
    
    if (isCollapsed) {
        main.classList.add('collapsed');
        menu.classList.add('collapsed');
        toggleBtn.textContent = '☰';
    }
});
</script>