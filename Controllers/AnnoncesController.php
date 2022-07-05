<?php
namespace App\Controllers;

class AnnoncesController extends Controller
{
    public function index()
    {
        $donnee = ['a','b','c'];
        include_once ROOT.'/Views/annonces/index.php';
    }
}