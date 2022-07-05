<?php
namespace App\Controllers;

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
    
}