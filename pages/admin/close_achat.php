<?php
session_start(); //démarrage de la session
require_once "../../includes/functions.php"; //importation des fonctions
areSetCookies(); //création de la session si cookies existent
if (!isConnected()){
    header("Location: ../index.php");
    exit();
} elseif (!isAdmin($conn,$_SESSION["utilisateur"]["uid"])) {
    header("Location: ../index.php");
    exit();
}

if(isset($_GET["id"])){
    try{
        require_once '../../includes/database.php'; //connexion BDD
        //maj de l'etat de l'article dans la BDD
        $requete = $conn->prepare("UPDATE achats SET date_fermeture = :date_fermeture, etat = :etat WHERE id_achat = :id_achat"); //requete et préparation
        $requete->execute(
            array(
                ":date_fermeture" => date("Y-m-d"),
                ":etat" => 2,
                ":id_achat" => sanitize($_GET["id"])
            )
        ); //execution de la requete

        header("Location: /pages/admin/achats.php"); //redirection
    }
    catch(Exception $e){ //en cas d'erreur
        die("Erreur : " . $e->getMessage());
    }
}
?>