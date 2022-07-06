<?php
namespace App\Models;

class AnnoncesModel extends Model
{
    protected $id;
    protected $titre;
    protected $description;
    protected $actif;
    protected $created_at;
    protected $users_id;

    public function __construct()
    {
        $this->table = 'annonces';
    }

    /**
     * Get the value of actif
     */ 
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     *
     * @return  self
     */ 
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

     /**
     * Get the value of users_id
     */ 
    public function getUsers_id():int
    {
        return $this->users_id;
    }

    /**
     * Set the value of users_id
     *
     * @return  self
     */ 
    public function setUsers_id(int $users_id)
    {
        $this->users_id = $users_id;

        return $this;
    }

}