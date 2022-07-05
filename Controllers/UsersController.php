<?php

namespace App\Controllers;

use App\Core\Form;

class UsersController extends Controller
{
    public function login()
    {
        $form = new Form;

        $form->debutForm('post', '#')
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('password', 'Password :')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

            $this->render('users/login', ['loginForm' => $form->create()]);

    }
}
