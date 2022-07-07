<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    /**
     * Connexion des utilisateurs
     *
     * @return void
     */
    public function login()
    {
        //On verifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'password'])) {
            // le formulaire est complet
            //on va chercher dans la base de données l'utilisateur avec l'email entré
            $userModel = new UsersModel;
            $userArray = $userModel->findOneByEmail(strip_tags($_POST['email']));

            if (!$userArray) {
                $_SESSION["erreur"] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
            }

            //l'utilisateur existe
            /* @var $user UsersModel */
            $user = $userModel->hydrate($userArray);

            //on vérifie si le mot de passe est correcte
            if (password_verify($_POST['password'], $user->getPassword())) {
                //le mot de passe est bon
                $user->setSession();
                header('Location: /');
                exit;
            } else {
                //Mauvais mot de passe
                $_SESSION["erreur"] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
                exit;
            }
        }

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

    /**
     * Inscription des utilisateurs
     *
     * @return void
     */
    public function register()
    {

        if (Form::validate($_POST, ['email', 'password'])) {
            //Le formulaire est valide
            $email = strip_tags($_POST['email']);
            //on chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            //on hydrate l'utilisateur
            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass);

            // on stocke l'utilisateur
            $user->create();
        }

        $form = new Form;

        $form->debutForm('post', '#')
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
            ->ajoutBouton('M\inscrire', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    /**
     * Deconnexion de l'utilisateur
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
