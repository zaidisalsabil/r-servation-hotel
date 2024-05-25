
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Rooms</title>
    <script>
        // The JavaScript confirmation function
        function confirmDelete(event) {
            var confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce plat?");
            if (!confirmation) {
                event.preventDefault(); // Prevent deletion if the user cancels
            }
        }
    </script>
    <style>
         th {
            background-color: #f7f7ba;
            color: black;
        } 
        .card {
            background-color: #f5f5dc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 500px;
            margin: 0 auto;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
          
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        tr{
            background-color:white;
        }
        tr:hover{
            background-color:#fcfce8;
        }

        .btn-sm {
            background-color: lemonChiffon;
            color:black;
        }
       
        .btn-da{
            background-color: Bisque;
            color:black;  
        }
        .btn-da:hover{
        
            color:black;  
        }
        .btn-pr{
            background-color:#ffffe0;
            color:black;
        }
        .btn-pr:hover{
            color:black;
        }
        h1.text-center {
            text-align: center;
            color: black;
        }
        .btn-pra{
            background-color: Bisque;
            color:black;  
        }
    </style>
</head>
<?php
ob_start();
session_start();

$pageTitle = 'Menu';

if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        // Fetch all menu items
        $query = "SELECT * FROM menu";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }

        echo "<h1 class='text-center' style='color: black;'> Menu</h1>";
        echo "<div class='container'>";
      
        echo "<table class='table  style='background-color: #f7f7ba;
        color: black;'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Type</th>";
        echo "<th>Prix</th>";
        echo "<th>Image</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Display all menu items
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = 'img/' . $row['image']; // Correct path for image

            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['prix'] . "</td>";
            echo "<td><img src='" . $imagePath . "' alt='Image' style='width:100px; height:100px;' /></td>";
            echo "<td> 
                <a href='?do=Edit&MenuId=" . $row['id'] . "' class='btn btn-sm' style='background-color: lemonChiffon;
                color:black;
            '>Modifier</a>
                <a href='Menu.php?do=Delete&menuId=" . $row['id'] . "' onclick='confirmDelete(event)' class='btn btn-da' >Supprimer</a>
            </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "<a href='?do=Add' class='btn btn-pr'><i class='fa fa-plus'></i> Ajouter</a>";
        echo "</div>";
        echo "</div>";

    } elseif ($do == 'Add') {
        // Add form for new menu items
        echo "<div class='container'>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='card border' style='background-color: white;'>";
        echo "<div class='card-body'>";
        echo "<h1 class='card-title text-center'>Ajouter nouveau plat</h1>";
        echo "<form action='?do=Insert' method='POST' enctype='multipart/form-data'>"; // 'enctype' for file uploads
        echo "<div class='form-group'>";
        echo "<label>Type</label>";
        echo "<input type='text' name='type' class='form-control' placeholder='Type' required />";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Prix</label>";
        echo "<input name='prix' class='form-control' placeholder='Prix' required />";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Image</label>";
        echo "<input type='file' name='image' class='form-control' />";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<input type='submit' value='Ajouter plat' class='btn btn-pra' style='background-color:Bisque' />";
        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

    } elseif ($do == 'Insert') {
        // Handle insertion of a new menu item
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = $_POST['type'];
            $prix = $_POST['prix'];
            $imageName = ''; // Default empty

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['image'];
                $imageName = basename($uploadedFile['name']); // Get the filename
                $targetDir = 'img/'; // Directory to store images
                $targetPath = $targetDir . $imageName;

                if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                    // Insert data into the database with the correct image path
                    $query = "INSERT INTO menu (type, prix, image) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, 'sis', $type, $prix, $imageName);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "<div class='alert alert-success'>Plat ajouté avec succès!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Erreur lors de l'ajout du plat.</div>";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "<div class='alert alert-danger'>Erreur lors du déplacement du fichier.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Erreur lors du téléchargement de l'image.</div>";
            }
        }

    } elseif ($do == 'Edit') {
        // Edit form for existing menu items
        $MenuId = isset($_GET['MenuId']) && is_numeric($_GET['MenuId']) ? intval($_GET['MenuId']) : 0;

        $query = "SELECT * FROM menu WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $MenuId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $menu = mysqli_fetch_assoc($result);

            echo "<h1 class='text-center'>Modifier Plat</h1>";
            echo "<div class='card'>";
            echo "<div class='container'>";
            echo "<form action='?do=Update' method='POST' enctype='multipart/form-data'>"; // 'enctype' for file uploads
            echo "<input type='hidden' name='MenuId' value='$MenuId' />";
            echo "<div class='form-group'>";
            echo "<label>Type</label>";
            echo "<input type='text' name='type' class='form-control' placeholder='Type' required value='" . $menu['type'] . "' />";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>Prix</label>";
            echo "<input name='prix' class='form-control' placeholder='Prix' required value='" . $menu['prix'] . "' />";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label> Image actuelle</label>";
            if ($menu['image']) {
                echo "<img src='img/" . $menu['image'] . "' alt='Current Image' style='width:100px; height:100px;' />";
            } else {
                echo "No image available";
            }
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>Nouvelle image</label>";
            echo "<input type='file' name='image' class='form-control' />";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<input type='submit' value='Enregistrer' class='btn btn-pra' />";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            echo"</div>";
        } else {
            echo "<div class='alert alert-danger'>Aucun plat trouvé avec cet identifiant.</div>";
        }

    } elseif ($do == 'Update') {
        // Handle updating of an existing menu item
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $MenuId = intval($_POST['MenuId']);
            $type = $_POST['type'];
            $prix = $_POST['prix'];
            $imageName = null; // Placeholder for the new image name

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                // If there's a new image
                $uploadedFile = $_FILES['image'];
                $imageName = basename($uploadedFile['name']);
                $targetDir = 'img/';
                $targetPath = $targetDir . $imageName;

                if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                    // Update with the new image
                    $query = "UPDATE menu SET type = ?, prix = ?, image = ? WHERE id = ?";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, 'sisi', $type, $prix, $imageName, $MenuId);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "<div class='alert alert-success'>Plat mis à jour avec succès.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du plat.</div>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "<div class='alert alert-danger'>Erreur lors du déplacement du fichier.</div>";
                }
            } else {
                // If there's no new image, update without changing the image
                $query = "UPDATE menu SET type = ?, prix = ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, 'si', $type, $prix, $MenuId);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='alert alert-success'>Plat mis à jour avec succès.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du plat.</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Requête invalide.</div>";
        }

    } elseif ($do == 'Delete') {
        // Handle the deletion of a menu item
        $MenuId = isset($_GET['menuId']) && is_numeric($_GET['menuId']) ? intval($_GET['menuId']) : 0;

        if ($MenuId > 0) {
            $query = "DELETE FROM menu WHERE id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $MenuId);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Plat supprimé avec succès.</div>";
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de la suppression du plat.</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>ID de plat invalide.</div>";
        }
    }

} else {
    header('Location: index.php');
    exit();
}

            