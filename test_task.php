<?php

function printCategories($categories) {
    foreach ($categories as $category) {
        if ($category['parent_id'] === null) {
            echo $category['id'] . ". " . $category['name'] . PHP_EOL;
        }
    }
}

function printSubcategories($categories, $parentId, $level = 1) {
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parentId) {
            echo str_repeat('--', $level) . $category['name'] . " (ID: " . $category['id'] . ")" . PHP_EOL;
            printSubcategories($categories, $category['id'], $level + 1);
        }
    }
}

function selectCategory($categories) {
    echo "Список категорий:" . PHP_EOL;
    printCategories($categories);
    
    $selectedId = readline("Введите ID категории для отображения её подкатегорий: ");
    
    $found = false;
    foreach ($categories as $category) {
        if ($category['id'] == $selectedId && $category['parent_id'] === null) {
            $found = true;
            echo "Подкатегории для категории: " . $category['name'] . PHP_EOL;
            printSubcategories($categories, $category['id']);
        }
    }
    
    if (!$found) {
        echo "Категория с ID $selectedId не найдена." . PHP_EOL;
    }
}

// Список категорий
$categories = [
    ['id' => 1, 'name' => 'Электроника', 'parent_id' => null],
    ['id' => 2, 'name' => 'Телефоны', 'parent_id' => 1],
    ['id' => 3, 'name' => 'Компьютеры', 'parent_id' => 1],
    ['id' => 4, 'name' => 'Ноутбуки', 'parent_id' => 3],
    ['id' => 5, 'name' => 'Игровые консоли', 'parent_id' => 1],
    ['id' => 6, 'name' => 'Телевизоры', 'parent_id' => 1],
    ['id' => 7, 'name' => 'Аудио техника', 'parent_id' => 1],
    ['id' => 8, 'name' => 'Домашняя электроника', 'parent_id' => 1],
    ['id' => 9, 'name' => 'Одёжда', 'parent_id' => null],
    ['id' => 10, 'name' => 'Мужская', 'parent_id' => 9],
    ['id' => 11, 'name' => 'Женская', 'parent_id' => 9],
    ['id' => 12, 'name' => 'Детская', 'parent_id' => 9],
    ['id' => 13, 'name' => 'Спорт', 'parent_id' => null],
    ['id' => 14, 'name' => 'Тренажеры', 'parent_id' => 13],
    ['id' => 15, 'name' => 'Спортивная одежда', 'parent_id' => 13],
    ['id' => 16, 'name' => 'Аксессуары для спорта', 'parent_id' => 13],
    ['id' => 17, 'name' => 'Книги', 'parent_id' => null],
    ['id' => 18, 'name' => 'Художественная литература', 'parent_id' => 17],
    ['id' => 19, 'name' => 'Научная литература', 'parent_id' => 17],
    ['id' => 20, 'name' => 'Учебная литература', 'parent_id' => 17],
];


// Также можно эту функцию вложить в бесконечный цикл, если
// требуется чтобы функция не прекращала работу после выполнения а вызывалась повторно
selectCategory($categories);
