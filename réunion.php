<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $durée = $_POST['durée']; 
    $con = mysqli_connect("localhost", "root", "", "hotel");
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    
    $end_time = date('H:i', strtotime($heure . ' +' . $durée . ' minutes'));

    
    $prev_end_time_sql = "SELECT MAX(ADDTIME(heure, SEC_TO_TIME(durée * 60))) AS prev_end_time FROM `sale de réunion` WHERE `date` = '$date'";
    $prev_end_time_result = mysqli_query($con, $prev_end_time_sql);
    $row = mysqli_fetch_assoc($prev_end_time_result);
    $prev_end_time = $row['prev_end_time'];

    if ($prev_end_time >= $heure) {
        echo "<script>alert('la salle est occupée');</script>";
        
    } else {
        $insert_sql = "INSERT INTO `sale de réunion`(`nom`, `email`, `date`, `heure`, `durée`) VALUES ('$nom','$email','$date','$heure', '$durée')";
        if (mysqli_query($con, $insert_sql)) {
            echo "<script>alert('réservation réussie.');</script>";
        } else {
            echo "خطأ: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<iframe src="nav.html" width="102%" height="70px" frameborder="0"></iframe>
<style>
        /* Ajoutez votre propre style CSS ici */
        .room-image {
          height: 300px; /* Définir la hauteur de l'image */
          object-fit: cover; /* Assurez-vous que l'image s'étend pour couvrir tout le cadre */
          margin-bottom: 20px; /* Espacement entre l'image et le texte */
          margin-top: 80px;
          margin-left: 100px;
        }
        .btn-pri{
          background-color:lightgray;
          color:black;
        }
        .room-description {
          text-align: left; /* Aligner le texte à gauche */
        }
        footer{
            margin-top: 50px;
        }
        button{
            background-color: rgb(168, 166, 162);

        }
      </style>


      <div class="container mt-4">
        <div class="row">
          <!-- Affichage de l'image à gauche -->
          <div class="col-md-6 order-md-2">
            <img src="images/reunion.jpeg" class="img-fluid room-image" alt="">
           
          </div>
          <!-- Affichage de la description et du formulaire de réservation à droite -->
          <div class="col-md-6 room-description order-md-1">
            <h2>Salle de réunion de luxe</h2>
            <p>
              L’hôtel BENI-HAMAD possède une salle de réunion pour 45 places .
              L’expérience et le savoir faire de notre staff garantissent la réussie de votre événement.
            </p>
            <!-- Formulaire de réservation -->
            <form action="réunion.php" method="post">
              <div class="form-group">
                  <label for="date"> Date :</label>
                  <input type="date" class="form-control" id="date" name="date" required>
              </div>
              <div class="form-group">
                  <label for="heure"> Heure :</label>
                  <input type="time" class="form-control" id="heure" name="heure" required>
              </div>
              <div class="form-group">
                  <label for="durée"> la durée :</label>
                  <input type="number" class="form-control" id="durée" name="durée" required>
              </div>

              <div class="form-group">
                  <label for="nom">Nom :</label>
                  <input type="text" class="form-control" id="nom" name="nom" required>
              </div>
              <div class="form-group">
                  <label for="email">Email :</label>
                  <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <button type="submit" class="btn btn-pri">Réserver la salle</button>
          </form>
          </div>
        </div>
      </div>
</body>
