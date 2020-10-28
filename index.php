<?php 

require_once("vendor/autoload.php");

use Renan\Model\Category;
use Renan\Model\User;
use Renan\Page;
use Renan\PageAdmin;
use Slim\Slim;


$app = new Slim();

$app->config('debug', true);
//////////////////////////// SITE ///////////////////////////////////
// HOME
$app -> get('/', function() {
    $page = new Page();
    $page -> setTpl('index');
});

// GET TEMPLATE BY CATEGORY ID
$app -> get('/categories/:idcategory', function($idcategory) {
    $category = new Category();
    $category -> get((int)$idcategory);

    $page = new Page();
    $page -> setTpl("category", [
        'category' => $category -> getValues(),
        'products' => []
    ]);
});
//////////////////////////// SITE - END///////////////////////////////////






/////////////////////////////// ADMIN ///////////////////////////////////
// GET TEMPLATE BY LOGIN CASE IS LOGGED
$app -> get('/admin', function() {
    User::verifyLogin();
    $page = new PageAdmin();
    $page -> setTpl('index');
});

// GET TEMPLATE OF LOGIN
$app -> get('/admin/login', function() {
    $page = new PageAdmin([
        "header" => false,
        "footer" => false
    ]);
    $page -> setTpl('login');
});

// POST TO TRY LOGIN IN ADMIN
$app -> post('/admin/login', function () {
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /admin");
    exit;
});

// METHOD OF LOGOUT
$app -> get('/admin/logout', function () {
    User::logout();
    header("Location: /admin/login");
    exit;
});
/////////////////////////////// ADMIN - END ///////////////////////////////////






/////////////////////////////// ADMIN USERS////////////////////////////////////
// LIST OF USERS
$app -> get('/admin/users', function () {
    User::verifyLogin();
    $users = User::listAll();
    $page = new PageAdmin();
    $page -> setTpl('users', array(
        "users" => $users
    ));
});

// GET TEMPLATE SCREEN CREATE USER
$app -> get('/admin/users/create', function () {
    User::verifyLogin();
    $page = new PageAdmin();
    $page -> setTpl('users-create');
});

// METHOD DELETE USER
$app -> get('/admin/users/:iduser/delete', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user -> get((int)$iduser);
    $user -> delete();

    header("Location: /admin/users");
    exit;
});

// GET USER BY ID METHOD
$app -> get('/admin/users/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user -> get((int)$iduser);
    $page = new PageAdmin();
    $page -> setTpl('users-update', array(
        "user" => $user -> getValues()
    ));
});

// CREATE USER METHOD
$app -> post('/admin/users/create', function () {
    User::verifyLogin();
    $user = new User();
    $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
    $user -> setData($_POST);

    $user -> save();

    header("Location: /admin/users");
    exit;
});

// METHOD UPDATE USER
$app -> post('/admin/users/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
    $user -> get((int)$iduser);
    $user -> setData($_POST);
    $user -> update();
    header("Location: /admin/users");
    exit;
});
/////////////////////////////// ADMIN USERS - END////////////////////////////////////





/////////////////////////////// ADMIN CATEGORIES ////////////////////////////////////
// TEMPLATE BY LIST ALL CATEGORIES
$app -> get('/admin/categories', function (){
    User::verifyLogin();
    $categories = Category::listAll();

    $page = new PageAdmin();
    $page -> setTpl("categories", [
        'categories' => $categories
    ]);
});

// GET TEMPLATE CREATE CATEGORIES
$app -> get('/admin/categories/create', function (){
    User::verifyLogin();
    $page = new PageAdmin();
    $page -> setTpl("categories-create");
});

// METHOD CREATE CATEGORIES
$app -> post('/admin/categories/create', function (){
    User::verifyLogin();
    $category = new Category();
    $category -> setData($_POST);
    $category -> save();

    header('Location: /admin/categories');
    exit;
});

// METHOD DELETE CATEGORIES
$app -> get('/admin/categories/:idcategory/delete', function ($idcategory){
    User::verifyLogin();
    $category = new Category();
    $category -> get((int)$idcategory);
    $category -> delete();

    header('Location: /admin/categories');
    exit;
});

// TEMPLATE GET BY ID CATEGORY
$app -> get('/admin/categories/:idcategory', function ($idcategory){
    User::verifyLogin();
    $category = new Category();
    $category -> get((int)$idcategory);

    $page = new PageAdmin();
    $page -> setTpl("categories-update", [
        "category" => $category -> getValues()
    ]);
    exit;
});

// EDIT CATEGORY METHOD
$app -> post('/admin/categories/:idcategory', function ($idcategory){
    User::verifyLogin();
    $category = new Category();
    $category -> get((int)$idcategory);
    $category -> setData($_POST);

    $category -> save();

    header('Location: /admin/categories');
    exit;
});
/////////////////////////////// ADMIN CATEGORIES - END////////////////////////////////////

$app->run();