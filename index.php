<?php
use App\Autoloader;
use App\Models\AnnoncesModel;
use App\Models\UsersModel;

require 'Autoloader.php';
Autoloader::register();

$model = new UsersModel;

$user = $model
    ->setEmail('brouette@gmail.com')
    ->setPassword('brouette', PASSWORD_ARGON2I);

$model->create($user);