<?php
namespace App\Controllers;

class Controller 
{

    public function render(string $fichier, $donnees = [], string $template = 'default')
    {
        //on extrait le contenu des donnees
        extract($donnees);

        //on demarre le buffer de sortie
        ob_start();
        // A partir de ce point toute sortie est consérvée en mémoire

        //On crée le chemin vert la vue 
        require_once ROOT.'/Views/'.$fichier.'.php';

        // Transfére le buffer dans comtenu
        $contenu = ob_get_clean();

        // template de page 
        require_once ROOT.'/Views/'.$template.'.php';
    }
    
}
