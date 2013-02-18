<?php

$fp_names = fopen('names', "r"); //lecture
$fp_names_fem = fopen('names_fem', "r"); //lecture
$fp_names_masc = fopen('names_masc', "r"); //lecture

$tab_names = anonymUtils::anonymiseLoadArray($fp_names);
$tab_names_fem = anonymUtils::anonymiseLoadArray($fp_names_fem);
$tab_names_masc = anonymUtils::anonymiseLoadArray($fp_names_masc);

$civGar = anonymUtils::getAnonymous($tab_names, $tab_names_masc);
$civFem = anonymUtils::getAnonymous($tab_names, $tab_names_fem);

$id_modifie = anonymUtils::getAnonymousId($tab_ids_used);


