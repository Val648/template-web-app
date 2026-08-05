<script>
    // Lire et appliquer l'état IMMÉDIATEMENT
    if (localStorage.getItem('menu-collapsed') === 'true') {
    }
</script>
    
<menu>
    <div id="title">
        <h1><?= $appName ?></h1>
        <button id="toggle-menu" title="Rétracter le menu">✕</button>
    </div>
    <?php include($basePath . "components/navigation.php") ?>
</menu>

<script>
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
    
    // Activer les transitions après le chargement
    // document.documentElement.classList.remove('menu-loaded');
});

document.getElementById('toggle-menu').addEventListener('click', function() {
    const main = document.querySelector('main');
    const menu = document.querySelector('menu');
    
    main.classList.toggle('collapsed');
    menu.classList.toggle('collapsed');
    
    const isCollapsed = menu.classList.contains('collapsed');
    localStorage.setItem('menu-collapsed', isCollapsed);
    this.textContent = isCollapsed ? '☰' : '✕';
});
</script>