<?php

require_once 'anonymUtils.php';
require_once 'user.php';

$fp_names = fopen('names', "r"); //lecture
$fp_names_fem = fopen('names_fem', "r"); //lecture
$fp_names_masc = fopen('names_masc', "r"); //lecture


$tab_names = anonymUtils::anonymiseLoadArray($fp_names);
$tab_names_fem = anonymUtils::anonymiseLoadArray($fp_names_fem);
$tab_names_masc = anonymUtils::anonymiseLoadArray($fp_names_masc);




$tab_ids_used = array(1,2,3);

$id_modifie = anonymUtils::getAnonymousId($tab_ids_used);

$tab_users = array();

for ($i=0; $i<100; $i++)
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
   
     $tab_users[] = $user;
}

$compteur = 1;
foreach ($tab_users as $value)
{
    echo "Utilisateur : ".$compteur ." ";
    echo $value->getId() . " " . $value->getNom() .
            " " .$value->getPrenom(). " " .$value->getGenre();
    echo "\n";
    $compteur ++;
}


