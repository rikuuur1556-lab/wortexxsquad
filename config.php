<?php
define('ADMIN_PASSWORD', 'Rik0ur_Pass_2026');
define('FILES_DIR', __DIR__ . '/files/');
define('CATS_FILE', __DIR__ . '/categories.json');

// Функция получения актуальных категорий
function get_categories() {
    if (!file_exists(CATS_FILE)) {
        // Если файла нет — создаем базовый
        $default = ['stiller', 'rat', 'crypter'];
        file_put_contents(CATS_FILE, json_encode($default));
        return $default;
    }
    $data = json_decode(file_get_contents(CATS_FILE), true);
    return is_array($data) ? $data : ['stiller', 'rat', 'crypter'];
}

// Инициализация папок при первом запуске
$cats = get_categories();
foreach ($cats as $cat) {
    $dir = FILES_DIR . $cat;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}
?>