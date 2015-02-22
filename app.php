<?php

/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->render('index');
});

// authentication e.g. http://stitchlite.com/shopify
$app->get('/shopify', function () use ($app) {
    echo $app['view']->render('shopify');
});

$app->post('/shopify', function () use ($app) {
    echo $app['view']->render('shopify');
});

// get all products from shopify and store them into stitchlite db. e.g. http://stitchlite.com/shopify/products
$app->get('/shopify/products', function () use ($app) {
    echo $app['view']->render('products');
});

// sync all products from stitchlite to shopify. Does post internally. (for testing in browser address bar)
// e.g. http://stitchlite.com/api/sync
$app->get('/api/sync', function () use ($app) {
    echo $app['view']->render('api/sync');
});

// post as per requirement. can be tested in postman
$app->post('/api/sync', function () use ($app) {
    echo $app['view']->render('api/sync');
});

// get all the products from stitchlite db http://stitchlite.com/api/products
$app->get('/api/products', function () use ($app) {
    echo $app['view']->render('api/products');
});

// get single product from stitchlite db. e.g. http://stitchlite.com/api/products/416523201
$app->get('/api/products/{id:[0-9]+}', function ($id) use ($app) {
    $app['view']->id = $id;
    echo $app['view']->render('api/products');
});


/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});