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

// get all products
$app->get('/shopify/products', function () use ($app) {
    echo $app['view']->render('products');
});

// sync all products. i.e. stitchlite
$app->get('/shopify/sync', function () use ($app) {
    echo $app['view']->render('sync');
});

//Searches for robots with $name in their name
$app->get('/api/robots/search/{name}', function($name) {

});

//Retrieves robots based on primary key
$app->get('/api/robots/{id:[0-9]+}', function($id) {

});

//Updates robots based on primary key
$app->put('/api/robots/{id:[0-9]+}', function() {

});

//Deletes robots based on primary key
$app->delete('/api/robots/{id:[0-9]+}', function() {

});

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
