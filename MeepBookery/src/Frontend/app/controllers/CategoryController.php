<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $category = $this->categoryModel->getAll();
        require_once "require_once __DIR__ . '/../views/admin-category.php";
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $description = $_POST["description"];
            if ($this->categoryModel->create($name, $description)) {
                header("Location: /");
                exit;
            }
        }
        require_once "require_once __DIR__ . '/../views/admin-category0-update-create.php";
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            header("Location: /category");
            exit;
        }
        $category = $this->categoryModel->getById($id);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $description = $_POST["description"];
            if ($this->categoryModel->update($id, $name, $description)) {
                header("Location: /");
                exit;
            }
        }
        require_once "require_once __DIR__ . '/../views/admin-category0-update-create.php";
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            header("Location: /category");
            exit;
        }  
        
        if ($this->categoryModel->delete($id)) {
            header("Location: /category");
            exit;
        }
    }
}
