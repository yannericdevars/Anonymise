<?php

// Fichier Php utilisé en tant que lanceur
// Simplifié pour les copier-coller

require_once 'anonymUtils.php';
require_once 'user.php';

$nb_utilisateurs = 10000; // Nobre d'utilisateurs à créer

$fp_names = fopen('names', "r"); //lecture
$fp_names_fem = fopen('names_fem', "r"); //lecture
$fp_names_masc = fopen('names_masc', "r"); //lecture


$tab_names = anonymUtils::anonymiseLoadArray($fp_names);
$tab_names_fem = anonymUtils::anonymiseLoadArray($fp_names_fem);
$tab_names_masc = anonymUtils::anonymiseLoadArray($fp_names_masc);




$tab_ids_used = array(1,2,3);

$id_modifie = anonymUtils::getAnonymousId($tab_ids_used);

$tab_users = array();

for ($i=0; $i<$nb_utilisateurs; $i++)
{
    $user = new user();
    $id_modifie = anonymUtils::getAnonymousId($tab_ids_used);
    $user->setId($id_modifie);
    
    $rand = rand(0, 1);
    
    if ($rand == 0)
    {
        $civUtil = anonymUtils::getAnonymous($tab_names, $tab_names_masc);
        $user->setGenre('M');
    }
    else
    {
        $civUtil = anonymUtils::getAnonymous($tab_names, $tab_names_fem);
        $user->setGenre('F');
    }
    
     $user->setPrenom($civUtil[1]);
     $user->setNom($civUtil[0]);
     $user->setLogin(anonymUtils::generateLogin($user->getNom(), $user->getPrenom()));
     $user->setPassword(anonymUtils::generatePassword());
   
     $tab_users[] = $user;
     
     if ($i % 500 == 0)
     {
         echo "Traitement du ".$i. " ème utilisateur.\n";
     }
}

$compteur = 1;
foreach ($tab_users as $value)
{
    $separator = " / ";   
    echo "Utilisateur : ".$compteur .$separator;
    echo 
    $value->getId() .       $separator .
    $value->getNom().       $separator .
    $value->getPrenom().    $separator .
    $value->getGenre().     $separator .
    $value->getLogin().     $separator .
    $value->getPassword();
    echo "\n";
    $compteur ++;
}


