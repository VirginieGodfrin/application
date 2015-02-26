<?php
namespace ISL\BlogBundle\Services;
/**
 * Description of AntiMotsInterdits
 *
 * @author gberger
 */
class AntiMotsInterdits {
    public function contientDesMotsInvalides($text) {
        return $this->compteLesMotsInvalides($text) >= 2;
    }
    public function combienDeMotsInvalides($text) {
        return $this->compteLesMotsInvalides($text);
    }
    private function compteLesMotsInvalides($text) {
        $compteur = 0;
        $liste_des_mots = array("nul","terroriste","nazi");

        foreach ($liste_des_mots as $mot) {
            if (strpos(strtolower($text),$mot) !== false) {
                $compteur++;
            }
        }
        return $compteur;
    }
}
