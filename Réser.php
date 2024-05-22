<?php

// Vérification si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adress = $_POST['adress'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date_darrive = $_POST['date_darrive'];
    $date_depart = $_POST['date_depart'];
    $type = $_POST['type']; // Ajout de la récupération du type de chambre

    // Connexion à la base de données
    $con = mysqli_connect("localhost", "root", "", "hotel");
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    // Vérification de la disponibilité de la chambre
    $requeteDisponibilite = "SELECT COUNT(*) AS nbChambresDisponibles FROM chambres WHERE type = '$type' AND disponible = 1 AND date_arrivee <= '$date_darrive' 
    AND date_depart >= '$date_depart'";
    $resultatDisponibilite = mysqli_query($con, $requeteDisponibilite);
    $rowDisponibilite = mysqli_fetch_assoc($resultatDisponibilite);
    $nbChambresDisponibles = $rowDisponibilite['nbChambresDisponibles'];

    // Si des chambres sont disponibles, ajouter les données du client à la base de données
    if ($nbChambresDisponibles > 0) {
        $sql = "INSERT INTO `client`(`nom`, `prenom`, `adress`, `email`, `telephone`, `date_darrive`, `date_depart`, `type_chambre`) 
            VALUES ('$nom','$prenom','$adress','$email','$telephone','$date_darrive','$date_depart')";
        
        if (mysqli_query($con, $sql)) {
            echo "Ajouté avec succès";
        } else {
            echo "Erreur lors de l'ajout : " . mysqli_error($con);
        }
        //type de chambre
        $type= $_POST['type'];
        $sqll= " INSERT INTO `type de chambre`(`type`) VALUES ('$type')";

     else {
        echo "Désolé, aucune chambre de ce type n'est disponible pour la période sélectionnée.";
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($con);
} else {
    echo "Aucune donnée à ajouter";
}


?>