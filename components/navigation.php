<nav>
    <ul>
        <?php foreach($navigation as $element): ?>
            <li>
                <a href="?page=<?= $element['page'] ?>">
                    <span><?= $element['icon'] ?></span>
                    <p><?= $element['label'] ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>