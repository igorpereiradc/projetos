<?php

require '../src/Database.php';
require '../src/Response.php';
require '../src/Router.php';
require '../src/TaskController.php';

$db = (new Database())->connect();
$task = new TaskController($db);
$router = new Router();

// rotas
$router->add('GET', '/tasks', [$task, 'list']);

$router->add('POST', '/tasks', [$task, 'create']);

$router->add('PUT', '/tasks/update', function() use ($task) {
    if (!isset($_GET['id'])) Response::json(['erro'=>'ID obrigatório'],400);
    $task->update($_GET['id']);
});

$router->add('DELETE', '/tasks/delete', function() use ($task){
    if (!isset($_GET['id'])) Response::json(['erro'=>'ID obrigatório'],400);
    $task->delete($_GET['id']);
});

// roda
$router->run();
