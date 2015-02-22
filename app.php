<?php

/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->render('index');
});

$app->get('/shopify', function () use ($app) {
    echo $app['view']->render('shopify');
});

//Retrieves all robots
$app->get('/api/robots', function() {

});

//Searches for robots with $name in their name
$app->get('/api/robots/search/{name}', function($name) {

});

//Retrieves robots based on primary key
$app->get('/api/robots/{id:[0-9]+}', function($id) {

});

//Adds a new robot
$app->post('/api/robots', function() {

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
