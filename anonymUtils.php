<?php

/**
 * Classe utilitaire pour rendre anonyme une base de données
 */
class anonymUtils
{

    private static $id_existants = array();
    private static $login_existants = array();

    /**
     * Lit un fichier pour anonymiser
     * @param file $fp Fichier contenant une liste de noms
     * @return array tableau de noms
     */
    public static function anonymiseLoadArray($fp)
    {
        while (!feof($fp))
        { //on parcourt toutes les lignes
            $tab_names[] = fgets($fp); // lecture du contenu de la ligne
        }

        return $tab_names;
    }

    /**
     * Créé un utilisateur anonyme
     * @param array $tabNames tableau de noms
     * @param array $tabFirst tableau de prénoms
     * @return array tableau contenant un nom et un prénom aléatoires
     */
    public static function getAnonymous($tabNames, $tabFirst)
    {
        $civilite = array();
        $civilite[0] = trim(self::getAnonymeByTab($tabNames));
        $civilite[1] = trim(self::getAnonymeByTab($tabFirst));

        $not_created = false;
        if ($civilite[0] == '')
        {
            $not_created = true;
            $civilite[0] = 'Anonymous';
        }
        if ($civilite[1] == '')
        {
            $not_created = true;
            $civilite[1] = 'Anonymous';
        }

        return $civilite;
    }

    public static function getAnonymeByTab($tabNames)
    {
        $selected_name = array_rand($tabNames);
        $string_returned = trim($tabNames[$selected_name]);

        if ($string_returned == '')
        {
            return self::getAnonymeByTab($tabNames);
        }
        return $string_returned;
    }

    /**
     * Retourne un id aléatoire
     * @param array $tab_ids_used tableau des ids déjà existants
     * @return int id aléatoire
     */
    public static function getAnonymousId($tab_ids_used)
    {
        $anonymousId = rand();

        if (count(self::$id_existants) == 0)
        {
            self::$id_existants = $tab_ids_used;
        }

        foreach (self::$id_existants as $ids)
        {
            if ($ids == $anonymousId)
            {
                return self::getAnonymousId(self::$id_existants);
            }
        }

        self::$id_existants[] = $anonymousId;
        return $anonymousId;
    }

    /**
     * Génère un nouveau mot de passe
     * @param int $longueur longueur du mot de passe en sortie (par défaut 8)
     * @return string Le mot de passe
     */
    public static function generatePassword($longueur = 8)
    {
        // ---------------------------------------------------------------------
        // Générer un mot de passe aléatoire
        // ---------------------------------------------------------------------
        // initialiser la variable $mdp
        $mdp = "";

        // Définir tout les caractères possibles dans le mot de passe,
        // Il est possible de rajouter des voyelles ou bien des caractères spéciaux
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

        // obtenir le nombre de caractères dans la chaîne précédente
        // cette valeur sera utilisé plus tard
        $longueurMax = strlen($possible);

        if ($longueur > $longueurMax)
        {
            $longueur = $longueurMax;
        }

        // initialiser le compteur
        $i = 0;

        // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
        while ($i < $longueur)
        {
            // prendre un caractère aléatoire
            $caractere = substr($possible, mt_rand(0, $longueurMax - 1), 1);

            // vérifier si le caractère est déjà utilisé dans $mdp
            if (!strstr($mdp, $caractere))
            {
                // Si non, ajouter le caractère à $mdp et augmenter le compteur
                $mdp .= $caractere;
                $i++;
            }
        }

        // retourner le résultat final
        return self::generateSha1($mdp);
    }

    /**
     * Génère un password crypté depuis un password 
     * @param string $password le password
     * @return string le mot de passe encrypté
     */
    private static function generateSha1($password)
    {
        return sha1($password);
    }

    /**
     * Génère un login en assurant l'unicité su login
     * @param string $name nom de l'utilisateur
     * @param string $first_name prenom de l'utilisateur
     * @return string Login généré
     */
    public static function generateLogin($name, $first_name)
    {
        $logintemp = $name . $first_name;

        $soon_exist = false;
        foreach (self::$login_existants as $exist)
        {
            if ($exist == $logintemp)
            {
                $soon_exist = true;
                break;
            }
        }

        if ($soon_exist)
        {
            $logintemp = $logintemp . "o";
        }

        self::$login_existants[] = $logintemp;
        return $logintemp;
    }

}

