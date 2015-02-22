<?php

/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->render('index');
});

// authentication
$app->get('/shopify', function () use ($app) {
    echo $app['view']->render('shopify');
});

$app->post('/shopify', function () use ($app) {
    echo $app['view']->render('shopify');
});

// get all products from shopify and store them into stitchlite db
$app->get('/shopify/products', function () use ($app) {
    echo $app['view']->render('products');
});

// sync all products from stitchlite to shopify
$app->get('/api/sync', function () use ($app) {
    echo $app['view']->render('api/sync');
});

$app->get('/api/products', function () use ($app) {
    echo $app['view']->render('api/products');
});


/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});