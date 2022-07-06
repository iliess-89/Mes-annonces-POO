<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnoncesModel;
class AnnoncesController extends Controller
{
    /**
     * Cette Methode affichera un page listant  toute les annonces de la base de donnees
     *
     * @return void
     */
    public function index(){
        // On instancie le modèle
        $annoncesModel = new AnnoncesModel;
    
        // On récupère les données
        $annonces = $annoncesModel->findBy(['actif' => 1]);

        //On génere la vue 
        $this->render('annonces/index', compact('annonces'));
    }

    /**
     * Affiche 1 annonce
     *
     * @param integer $id Id de l'annonce
     * @return void
     */
    public function lire(int $id)
    {
        //on instncie le modéle
        $annoncesModel = new AnnoncesModel;

        //On va chercher 1 annonce
        $annonce = $annoncesModel->find($id);

        // On envoie a la vue 
        $this->render('annonces/lire', compact('annonce'));
    }


    /**
     * Ajouter un annonces
     * @return void
     */
    public function ajouter()
    {
        //on vérifie  si l'utilisateur est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){
            // L'utilisateur est connecté
            //on verifie si le formulaire est comptet 
            if(Form::validate($_POST, ['titre', 'description'])){
                //le formulaire est complet
                //On va se protéger contre les failles XSS
                $titre = strip_tags($_POST['titre']); 
                $description = strip_tags($_POST['description']);

                //On instancie notre model
                $annonce = new AnnoncesModel;

                //on hydrate
                $annonce->setTitre($titre)
                ->setDescription($description)
                ->setActif(0)
                ->setUsers_id($_SESSION['user']['id'])
                ;
               
                $annonce->create();

                $_SESSION['message'] = "Votre annconce a bien été enregistrée avec succés";
                header('Location: /');
                exit;
    
            }else{
                //le formulaire est incompet
                $_SESSION['erreur'] = !empty($_POST) ? 'Le formulaire est incomplet' : '';
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : ''; 
                $description = isset($_POST['titre']) ? strip_tags($_POST['description']) : '';
        
            }

            $form = new Form;

            $form->debutForm()
            ->ajoutLabelFor('titre', 'Titre de l\'annonces :')
            ->ajoutInput('texte', 'titre', [
                'id' => 'titre', 
                'class' => 'form-control',
                'value' => $titre
                ])
            ->ajoutLabelFor('description', 'Texte de l\'annonces :')
            ->ajoutTextarea('description', $description, ['id' => 'description', 'class' => 'form-control'])
            ->ajoutBouton('Ajouter',  ['class' => 'btn btn-primary'])
            ->finForm()
            ;

            $this->render('annonces/ajouter', ['form' => $form->create()]);

        }else{
            //l'utilisateur n'est pas connecter
            $_SESSION['erreur'] = "Vous devez etre connecté(e) pour accéder à cette page";
            header('Location: /users/login');
            exit;
        }
    }
    

    /**
     * Modifier une annonces
     *
     * @param integer $id
     * @return void
     */
    public function modifier(int $id)
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){
            //On va verifier si l'annonces existe dans la base 
            //On instanci notre model
            $annoncesModel = new AnnoncesModel;

            //on chercher l'annonce avec l'id $id
            $annonce = $annoncesModel->find($id);  

            //si l'annonces n'existe pas, on retoune a la page liste des annonces
            if(!$annonce){
                http_response_code(404);
                $_SESSION['erreur'] = "L'annonce rechercher n'existe pas";
                header('Location: /annonces');
                exit;
            }

            //On vérifi si l'utilisateur est propriétaires de l'annonces
            if($annonce->users_id !== $_SESSION['user']['id']){
                $_SESSION['erreur'] = "vous n'avez pas accés à cette page";
                header('Location: /annonces');
                exit;
            }

            //on traite le formulaire 
            if(Form::validate($_POST, ['titre', 'description'])){
                //on se protege contre les fails xss
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                //on stocke l'annonce 
                $annonceModel = new AnnoncesModel;
                
                //on hydrate 
                $annonceModel->setId($annonce->id)
                ->setTitre($titre)
                ->setDescription($description)
                ;

                //on met a jour l'annonce
                $annonceModel->update();

                $_SESSION['message'] = "Votre annconce a bien été modifiée avec succés";
                header('Location: /');
                exit;
            }

            $form = new Form;

            $form->debutForm()
            ->ajoutLabelFor('titre', 'Titre de l\'annonces :')
            ->ajoutInput('texte', 'titre', [
                'id' => 'titre',
                'class' => 'form-control',
                'value' => $annonce->titre 
            ])
            ->ajoutLabelFor('description', 'Texte de l\'annonces :')
            ->ajoutTextarea('description', $annonce->description, [
                    'id' => 'description',
                    'class' => 'form-control'
            ])
            ->ajoutBouton('Modifier',  ['class' => 'btn btn-primary'])
            ->finForm()
            ;
            
            //On envoie a la vue 
            $this->render('annonces/modifier', ['form' => $form->create()]);

        }else{
            //l'utilisateur n'est pas connecter
            $_SESSION['erreur'] = "Vous devez etre connecté(e) pour accéder à cette page";
            header('Location: /users/login');
            exit;
        }
    }
}