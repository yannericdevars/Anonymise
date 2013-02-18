<?php

/**
 * Classe utilitaire pour rendre anonyme une base de données
 */
class anonymUtils {

    private static $id_existants = array();

    /**
     * Lit un fichier pour anonymiser
     * @param file $fp Fichier contenant une liste de noms
     * @return array tableau de noms
     */
    public static function anonymiseLoadArray($fp) {
        while (!feof($fp)) { //on parcourt toutes les lignes
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
    public static function getAnonymous($tabNames, $tabFirst) {
        $civilite = array();
        $civilite[0] = self::getAnonymeByTab($tabNames);
        $civilite[1] = self::getAnonymeByTab($tabFirst);

        $not_created = false;
        if ($civilite[0] == '') {
            $not_created = true;
            $civilite[0] = 'Anonymous';
        }
        if ($civilite[1] == '') {
            $not_created = true;
            $civilite[1] = 'Anonymous';
        }

        return $civilite;
    }

    public static function getAnonymeByTab($tabNames) {
        $selected_name = array_rand($tabNames);
        $string_returned = trim($tabNames[$selected_name]);

        if ($string_returned == '') {
            return self::getAnonymeByTab($tabNames);
        }
        return $string_returned;
    }

    /**
     * Retourne un id aléatoire
     * @param array $tab_ids_used tableau des ids déjà existants
     * @return int id aléatoire
     */
    public static function getAnonymousId($tab_ids_used) {
        $anonymousId = rand();

        if (count(self::$id_existants) == 0) {
            self::$id_existants = $tab_ids_used;
        }

        foreach (self::$id_existants as $ids) {
            if ($ids == $anonymousId) {
                return self::getAnonymousId(self::$id_existants);
            }
        }

        self::$id_existants[] = $anonymousId;
        return $anonymousId;
    }
}

