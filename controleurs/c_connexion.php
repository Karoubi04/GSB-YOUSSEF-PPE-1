<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Omrani Youssef
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $visiteur = $pdo->getInfosVisiteur($login, $mdp);
    $comptable = $pdo->getInfosComptable($login, $mdp);
 
    if (!is_array($visiteur) && !is_array($comptable)) { //si il n y a a rien dans visiteur et comptable
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
     } else {
       if (is_array($visiteur)){
       $id = $visiteur['id'];
       $nom = $visiteur['nom'];
       $prenom = $visiteur['prenom'];
       $statut='visiteur';
       ajouterErreur('Bien connecte');
       
       }  elseif (is_array($comptable)){
           $id = $comptable['id'];
           $nom = $comptable['nom'];
           $prenom = $comptable['prenom'];
           $statut='comptable';
       }
           connecter($id, $nom, $prenom, $statut);
           header('Location: index.php');
       }
   break;
default:
    include 'vues/v_connexion.php';
    break;
}
