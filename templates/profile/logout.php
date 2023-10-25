<?php
global $router;
unset($_SESSION['user']['id']);
$router->redirect('login');