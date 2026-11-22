<?php
require 'config.php';
$categories = get_categories();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>WortexXSquad | File Hosting</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header-wrap">
    <div class="dots-smile" id="dots-smile"></div>
</div>

<div class="container">
    <h1>WortexXSquad // FILES</h1>

    <!-- Кнопки фильтра -->
    <div class="filter-bar" id="filter-bar">
        <button class="filter-btn active" data-cat="all">ALL</button>
        <?php foreach ($categories as $cat): ?>
            <button class="filter-btn" data-cat="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
        <?php endforeach; ?>
    </div>

    <!-- Список категорий -->
    <div id="files-container">
        <?php foreach ($categories as $cat): ?>
            <div class="category" data-category="<?= htmlspecialchars($cat) ?>">
                <h2><?= htmlspecialchars($cat) ?></h2>
                <ul class="file-list">
                    <?php
                    $dir = FILES_DIR . $cat;
                    $files = is_dir($dir) ? array_diff(scandir($dir), ['.', '..']) : [];
                    if (empty($files)) {
                        echo '<li><span class="size">[пусто]</span></li>';
                    }
                    foreach ($files as $file) {
                        $path = $dir . '/' . $file;
                        if (is_file($path)) {
                            $size = round(filesize($path) / 1024, 2) . ' KB';
                            $url = 'files/' . rawurlencode($cat) . '/' . rawurlencode($file);
                            echo '<li><a href="' . $url . '" download>' . htmlspecialchars($file) . '</a><span class="size">' . $size . '</span></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Генерация точечного смайлика
const smileContainer = document.getElementById('dots-smile');
const pattern = [
    [0,1,1,0,1,1,0],
    [0,1,1,0,1,1,0],
    [0,0,0,0,0,0,0],
    [1,0,0,0,0,0,1],
    [0,1,0,0,0,1,0],
    [0,0,1,1,1,0,0],
    [0,0,0,0,0,0,0]
];
pattern.forEach(row => {
    row.forEach(cell => {
        const dot = document.createElement('div');
        dot.className = 'dot' + (cell === 1 ? '' : ' empty');
        dot.style.animationDelay = Math.random() * 2 + 's';
        smileContainer.appendChild(dot);
    });
});

// Логика фильтрации
const filterBtns = document.querySelectorAll('.filter-btn');
const categories = document.querySelectorAll('.category');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Убираем активный класс со всех
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const targetCat = btn.dataset.cat;

        categories.forEach(catDiv => {
            if (targetCat === 'all' || catDiv.dataset.category === targetCat) {
                catDiv.style.display = 'block';
            } else {
                catDiv.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>