<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['Email'];
    $date = $_POST['date'];
    $temps = $_POST['temps'];
    $nbr_persn = $_POST['nbr_persn'];
    $type_plat = isset($_POST['food_types']) ? implode(', ', $_POST['food_types']) : '';

    $con = mysqli_connect("localhost", "root", "", "hotel");
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $sql = "INSERT INTO `réstaurant`(`nom`, `prenom`, `email`, `date`, `temps`, `nbr_persn`, `plat_types`) 
            VALUES ('$nom', '$prenom', '$email', '$date', '$temps', '$nbr_persn', '$type_plat')";

    if (mysqli_query($con, $sql)) {
        echo "<script> alert('Réservation réussie.'); </script>";
    } else {
        echo "Erreur lors de l'ajout : " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver votre table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2 class="Réser">Réserver votre table</h2>
    <form action="table.php" method="POST">
        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom" required><br>
        
        <label for="prenom">Prenom</label><br>
        <input type="text" id="prenom" name="prenom" required><br>
        
        <label for="Email">Email</label><br>
        <input type="email" id="Email" name="Email" required><br>
        
        <label for="date">Date</label><br>
        <input type="date" id="date" name="date" required><br>
        
        <label for="temps">Temps</label><br>
        <input type="time" id="temps" name="temps" required><br>
        
        <label for="nbr_persn">Nombre de personnes</label><br>
        <input type="number" id="nbr_persn" name="nbr_persn" required><br>
        
        <label for="type_plat">Type de plat</label><br>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hotel");
        if (!$con) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }

        $query = "SELECT DISTINCT `type` FROM `menu`";
        $result = mysqli_query($con, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<input type='checkbox' name='food_types[]' value='" . $row['type'] . "'> " . $row['type'] . "<br>";
            }
            mysqli_free_result($result);
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_close($con);
        ?><br>
        
        <input type="submit" value="Réserver">
    </form>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: left;
            margin-top: 50px;
        }

        form {
            width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="time"],
        input[type="number"],
        input[type="submit"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4748486c;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4748486c;
        }

        .Réser {
            text-align: center;
        }
    </style>
</body>
</html>
