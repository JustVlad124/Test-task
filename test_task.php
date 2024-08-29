<?php

class Category {
    public $id;
    public $name;
    public $parent_id;
    public $children = [];

    public function __construct($id, $name, $parent_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
    }

    public function addChild(Category $child) {
        $this->children[] = $child;
    }
}

class CategoryManager {
    private $categories = [];
    private $flatList = [];

    public function addCategory(Category $category) {
        $this->flatList[$category->id] = $category;
        if ($category->parent_id === null) {
            $this->categories[] = $category;
        } else {
            $this->flatList[$category->parent_id]->addChild($category);
        }
    }

    public function displayCategories($categories = null, $level = 0) {
        if ($categories === null) {
            $categories = $this->categories;
        }

        $output = '';
        foreach ($categories as $index => $category) {
            $indent = str_repeat("  ", $level);
            $output .= $indent . ($index + 1) . ". " . $category->name . " (ID: " . $category->id . ")\n";
        }
        return $output;
    }

    public function getCategoryById($id) {
        return $this->flatList[$id] ?? null;
    }

    public function interactiveNavigation() {
        $currentCategories = $this->categories;
        $breadcrumbs = [];

        while (true) {
            echo "Текущий уровень: " . implode(" > ", array_map(function($cat) { return $cat->name; }, $breadcrumbs)) . "\n";
            echo $this->displayCategories($currentCategories);
            echo "Выберите категорию (введите номер) или введите 'b' для возврата, 'q' для выхода: ";
            
            $input = trim(fgets(STDIN));

            if ($input === 'q') {
                break;
            } elseif ($input === 'b') {
                if (!empty($breadcrumbs)) {
                    array_pop($breadcrumbs);
                    $currentCategories = empty($breadcrumbs) ? $this->categories : end($breadcrumbs)->children;
                }
                continue;
            }

            $index = intval($input) - 1;
            if (isset($currentCategories[$index])) {
                $selectedCategory = $currentCategories[$index];
                if (!empty($selectedCategory->children)) {
                    $breadcrumbs[] = $selectedCategory;
                    $currentCategories = $selectedCategory->children;
                } else {
                    echo "Эта категория не имеет подкатегорий.\n";
                }
            } else {
                echo "Неверный ввод. Пожалуйста, попробуйте снова.\n";
            }
        }
    }
}

// Пример использования
$manager = new CategoryManager();

$manager->addCategory(new Category(1, "Электроника"));
$manager->addCategory(new Category(2, "Телефоны", 1));
$manager->addCategory(new Category(3, "Смартфоны", 2));
$manager->addCategory(new Category(4, "Кнопочные телефоны", 2));
$manager->addCategory(new Category(5, "Компьютеры", 1));
$manager->addCategory(new Category(6, "Ноутбуки", 5));
$manager->addCategory(new Category(7, "Настольные ПК", 5));
$manager->addCategory(new Category(8, "Одежда"));
$manager->addCategory(new Category(9, "Мужская", 8));
$manager->addCategory(new Category(10, "Женская", 8));

$manager->interactiveNavigation();