<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="reservation.css">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
   
    <iframe src="nav.html" width="103%" height="80px" frameborder="0" ></iframe>
    <img src="images/undraw_travel_booking_re_6umu (1).svg" alt="" height="40%" width="40%" class="image">
    <div class="container mt-5" width="50px" height="40px">
        <h2 class="text-center mb-4">Réservez votre séjour</h2>
        <form action="Réser.php" method="post">
            <div class="row"  >
                <div class="col-md-6">
                    <div class="form-group" width="40px">
                        <label for="nom">Nom:</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">adress:</label>
                        <input type="text" class="form-control" id="adresse" name="adress" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    

                </div>
               
             
        </div>
            <button type="submit" class="btn btn-primary btn-block">Réserver</button>
        </form>
    </div>
  <style>

body {
    font-family: Arial, sans-serif;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    border: 1px solid #eee;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.form-group label {
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="tel"],
.form-group input[type="date"],
.form-group select {
    width: calc(100% - 20px);
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

.btn-primary {
    background-color:gray;
    border-color :coral;
    color:black;
}

.btn-primary:hover {
    background-color:bisque;
    border-color:bisque;
}
body{
    background-color:  #f2f2f2;
}
  </style>
    <script src="js/popper.min js.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    
    
</body>
</html>
<?php

session_start();  // Continue the session
$con = mysqli_connect("localhost", "root", "", "hotel");
if (!$con) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adress = $_POST['adress'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // Get reservation data from session
    if (isset($_SESSION['reservation_data'])) {
        $date_darrive = $_SESSION['reservation_data']['date_darrive'];
        $date_depart = $_SESSION['reservation_data']['date_depart'];
        $type = $_SESSION['reservation_data']['type'];
    } else {
        die("Erreur : données de réservation non trouvées.");
    }

    // Insert all data into the client table
    $requeteInsert = "INSERT INTO client (nom, prenom, adress, email, telephone, date_darrive, date_depart, type)
                      VALUES ('$nom', '$prenom', '$adress', '$email', '$telephone', '$date_darrive', '$date_depart', '$type')";

    if (mysqli_query($con, $requeteInsert)) {
        echo "<script>alert('Réservation réussie.'); </script>";
    } else {
        echo "Erreur lors de l'insertion: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    echo "Aucune donnée à traiter.";
}
?>
