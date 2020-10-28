<?php

use Renan\Model\Product;
use Renan\Model\User;
use Renan\PageAdmin;
use Slim\Slim;

$app->get("/admin/products", function () {
    User::verifyLogin();
    $products = Product::listAll();
    $page = new PageAdmin();
    $page->setTpl('products', [
        'products' => $products
    ]);
});

