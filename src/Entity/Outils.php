<?php


namespace App\Entity;

class Outils {

    //premier lettre en MAj
    public function firstLetterMaj($email){
        return ucfirst($email);
    }

    public function ValidPhoneNumber($tel){
        return strlen($tel) == 10;
    }
    
    public function valid_donnees($donnees){
        $donnees = htmlspecialchars(strip_tags(trim($donnees)));//va "empecher/retirer" les espaces, les <,/,> , injections...
        return $donnees;
    }

    public function validerEmail($email){
        // Nettoyer l'email en utilisant la fonction valid_donnees
        $email = $this->valid_donnees($email);

        // Valider la structure de l'email en utilisant FILTER_VALIDATE_EMAIL
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Valider que l'email contienne ".fr" ou ".com" et un arobase avant le ".com" ou ".fr"
            if (preg_match('/@(.*\.fr|.*\.com)$/', $email)) {
                return $email; // L'email est valide
            } else {
                return false; // L'email n'est pas valide
            }
        } else {
            return false; // L'email n'est pas valide selon FILTER_VALIDATE_EMAIL
        }
    }

    public function validPassword($password){
        // Retournez true si le mot de passe est valide, sinon false.
        // Exemple le mdp doit avoir au moins 4 caracteres :
        return strlen($password) >= 4;
    }

    public function onlyStrings($prenom) {
        // Supprime les espaces en début et en fin de chaîne
        $prenom = trim($prenom);
    
        // Vérifie que les variables ne sont pas vides
        if (empty($prenom)) {
            return false;
        }
    
        // Utilise une expression régulière (regex) pour vérifier que seules des lettres sont présentes et qu'il y a au moins 3 lettres
        $regex = '/^[a-zA-Z]{3,}$/';
    
        if (preg_match($regex, $prenom)) {
            return true; // Les variables contiennent uniquement des lettres et ont au moins 3 lettres chacune
        } else {
            return false; // Les variables ne satisfont pas les critères
        }
    }
    
}


