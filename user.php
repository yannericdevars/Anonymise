<?php
/**
 * Classe du User
 *
 * @author yann-eric@live.fr
 */
class user
{
    private $id;
    private $nom;
    private $prenom;
    private $genre;
    private $login;
    private $password;
    
    /**
     * Constructeur de classe
     */
    public function __construct()
    {
        ;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function getGenre()
    {
        return $this->genre;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setId($var)
    {
        $this->id = $var;
    }
    public function setNom($var)
    {
        $this->nom = $var;
    }
    public function setPrenom($var)
    {
        $this->prenom = $var;
    }
    public function setGenre($var)
    {
        $this->genre = $var;
    }
    public function setLogin($var)
    {
        $this->login = $var;
    }
    public function setPassword($var)
    {
        $this->password = $var;
    }
    
}

?>
