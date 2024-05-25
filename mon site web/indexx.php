<?php
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "hotel");
if (!$con) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $date_darrive = $_POST['date_darrive'];
    $date_depart = $_POST['date_depart'];
    $type = $_POST['type'];

    // Prepare the reservation data to be stored in session
    $_SESSION['reservation_data'] = [
        'date_darrive' => $date_darrive,
        'date_depart' => $date_depart,
        'type' => $type,
    ];

    // Query to check for available rooms of the specified type
    $requeteDisponibilite = "SELECT * FROM chambre 
                             WHERE type = '$type' 
                             AND statut = 1";  // Status 1 indicates available

    $resultatDisponibilite = mysqli_query($con, $requeteDisponibilite);
    if (!$resultatDisponibilite) {
        die("Erreur de requête SQL : " . mysqli_error($con));
    }

    // Count the available rooms
    $availableRooms = mysqli_num_rows($resultatDisponibilite);

    // Query to check overlapping reservations
    $requeteVerif = "SELECT * FROM client 
                     WHERE type = '$type' 
                     AND (
                         ('$date_darrive' BETWEEN date_darrive AND date_depart) OR 
                         ('$date_depart' BETWEEN date_darrive AND date_depart) OR
                         (date_darrive BETWEEN '$date_darrive' AND '$date_depart') OR 
                         (date_depart BETWEEN '$date_darrive' AND '$date_depart')
                     )";

    $resultatVerif = mysqli_query($con, $requeteVerif);
    
    if (!$resultatVerif) {
        die("Erreur de requête SQL : " . mysqli_error($con));
    }

    // Count the conflicting reservations
    $conflictingReservations = mysqli_num_rows($resultatVerif);
  
    if ($conflictingReservations >= $availableRooms) {
        // If there are more or equal conflicting reservations than available rooms, it's unavailable
        echo "<script>alert('Désolé, toutes les chambres de ce type sont réservées pour cette période.');</script>";
    } else {
        // If there are fewer conflicting reservations than available rooms, at least one room is available
        $requeteInsert = "INSERT INTO client (date_darrive, date_depart, type) 
                          VALUES ('$date_darrive', '$date_depart', '$type')";

        if (mysqli_query($con, $requeteInsert)) {
            echo "<script>alert('La chambre est disponible. Vous pouvez réserver.'); window.location.href='Réser.php';</script>";
        } else {
            echo "Erreur lors de l'insertion: " . mysqli_error($con);
        }
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // Handle the case where the form is not submitted
}
?>

  
  
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexx.css">
    <link rel="stylesheet" href="bar.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"    />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
   

    <title>Hotel BENI HAMAD</title>
   
<style>
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}



.container, .section_container {
    flex: 1;
}

</style>
    
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="images/logo d'hotel.png" width="90" height="60" alt="Logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link p-lg-3" aria-current="page" href="#">Accueil</a>
          </li>
         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-lg-3" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              Services & loisirs
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="chambre.html">Les chambres</a></li>
              <li><a class="dropdown-item" href="restaurant.php">Restaurant</a></li>
              <li><a class="dropdown-item" href="réunion.php">Salle de réunion</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link p-lg-3" href="tarifs.html">Tarifs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-lg-3" href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
    <header class="section_container header_container">
        <div class="header_image_container">

            <div class="header_content">
                <h1>Profitez de vos
                      vocances de rêve</h1>
                <p> Réservez votre séjour dès maintenant et profitez des meilleures offres et des tarifs exclusifs.</p>
            </div>

            <div class="Beni-hamad_container">
              
               <form method="POST" action=""> <!-- New PHP script to handle the check -->
              
            
    <div class="form_group">
        <div class="input_group">
            <input type="date" id="check-in-date" name="date_darrive" required>
        
        </div>
    </div>
    <div class="form_group">
        <div class="input_group">
            <input type="date" id="check-out-date" name="date_depart" required>
            <label></label>
        </div>
    </div>
    <div class="form_group"style="margin-top:10px; ">
        <div class="input_group ">
            <select class="form-control" id="type" name="type" required>
                <option value="">Choisissez le type de chambre</option>
                <option value="single">Chambre single</option>
                <option value="double">Chambre double</option>
                <option value="suite_junior_single">Suite Junior single</option>
                <option value="suite_junior_double">Suite Junior double</option>
                <option value="suite_senior_single">Suite Senior single</option>
                <option value="suite_senior_double">Suite Senior double</option>
            </select>
            <label></label>
        </div>
    </div>
    <div class="container text-center mt-5">
        <button type="submit" class="btn btn-black">
            <i  style="font-size:30px;width:100px; margin: bottom 100px;"class="bi bi-search"></i>
   
</form>
</div>
        </div>
    </header>

    <section class="section_container popular_container" >
        <h2 class="section_header"> Nos services</h2>
        <div class="popular_grid">
            <div class="popular_card">
                <img src="images/pexels-castorlystock-3682238.jpg" alt=" popular hotel" >
                <div class="popular_content">
                <div class="popular_card_header">
                    <h4> Les Chambres</h4>
                 
                </div>
                <p><a href="chambre.html" class="a">Plus...</a></p>

            </div>
        </div>

        <div class="popular_card">
            <img src="images/pexels-fauxels-3184465.jpg" alt=" popular hotel" >
            <div class="popular_content">
            <div class="popular_card_header">
                <h4>Salle de réunion</h4>
                
            </div>
            <p><a href="réunion.php" class="a">Réserver maintenant</a></p>

        </div>
    </div>

    <div class="popular_card" >
        <img src="images/pexels-ekrulila-2349995.jpg" alt=" popular hotel" >
        <div class="popular_content">
        <div class="popular_card_header">
            <h4>Restaurant</h4>
            
        </div>
        <p><a href="restaurant.php" class="a">Réserver maintenant</a></p>

    </div>
 </div>
        </div>
    </section>
    <section class="client">
        <div class="section_container client_container">
            <h2 class="section_header" margin-top="20px">
                ce que disent nos clients
            </h2>
            <div class="client_grid">
                <div class="client_card">
                    <i class="bi bi-chat-dots"></i>
                    <img src="images/undraw_female_avatar_efig (1).svg" alt="">
                    <p>L'hôtel est très propre et calme, l'accueil était bon, les chambres sont spacieuses et confortables, 
                        le lit est très agréable, on peut y rester toute la journée. Le WiFi est excellent, 
                        le petit-déjeuner était très délicieux et varié. Je recommande pleinement cet hôtel charmant.</p>
                </div>
                <div class="client_card">
                    <img src="images/undraw_male_avatar_g98d.svg" alt="">
                    <p>J'ai eu une excellente expérience, un service formidable, un hôtel incroyable, heureux de voir un tel service client à BBA, 
                        merci à l'équipe de l'Hôtel Beni Hamad, un jour je reviendrai. 
                        Il faut améliorer de petites choses mais dans l'ensemble, c'était fantastique.</p>
                </div>

                <div class="client_card">
                    <img src="images/undraw_pic_profile_re_7g2h.svg" alt="">
                    <p>Je recommande vivement l'hôtel qui est agréable, calme, propre et l'équipe est très professionnelle et surtout compétente. Un grand merci à Foued à la réception qui est vraiment le premier contact qui fait toute la différence, 
                        suivi d'un service très agréable au restaurant par 
                        Abdel, ce qui a rendu le séjour plaisant et digne d'être répété. Cordialement.</p>
                </div>

            </div>
        </div>
    </section>


  <section class="section_container">
    <div class="reward_container">
        <p>Codes de réduction</p>
        <h4>Rejoignez les récompenses et découvrez des remises incroyables sur vos achats à Beni Hamad</h4>
        <button class="reward_btn"> Rejoignez les récompenses</button>
    </div>
  </section>
  <footer class="footer">
    <div class="section_container footer_container">
        <div class="footer_col">
            <h3>Beni Hamad</h3>
            <p>
              Beni Hamad se distingue en tant que destination unique pour séjourner, incarnant la beauté de la simplicité et 
              du confort dans un seul hôtel exceptionnel. Grâce à son caractère distinctif et à ses services uniques.
            </p>
            <p>Beni Hamad offre aux voyageurs l'opportunité d'explorer la région en toute tranquillité et facilité.
            </p>

        </div>

        <div class="footer_col">
            <h4>contact</h4>
            <p><a href="mailto:info@hotel-benihamad.dz">info@hotel-benihamad.dz</a></p>
            <p>+213(0)35.69.02.02</p>
            </div>
   <script src="js/popper.min js.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>
</html>