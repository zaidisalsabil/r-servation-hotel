<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <!--Style Link-->
    <link rel="stylesheet" href="restaurant.css">
</head>
<body>
    <!-- Header Start -->
    <header>
        <div id="navbar">
            <img src="./img/logo.png" alt="Food Lover Logo">
            <nav>
                <ul>
                    
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="indexx.php">Acceuil</a></li>
                  
                   
                </ul>
            </nav>
        </div>
    
    
    <div class="content">
        <h1>Bienvenue Au <span claas="primary-text" > Restaurant </span>   BENI HAMAD </h1>
        <p>Ici vous pouvez trouver la nourriture la plus délicieuse au monde</p>
        <a href="table.php" class="btn btn-primary"> Réserver une Table</a>
    </div>
</header>
<style>
     #offers .offers-items {
    display: flex;          /* Enables flexbox layout */
    gap: 200px;              /* Adds 20px of space between items */
    justify-content: center; /* Center aligns the items */
}
#offers h2{
    margin:50px;
    text-align:center;

}
.offers-items > div{
    margin: 10opx;   /* Adds a 10px margin around each item */
}



        /* Styles for the menu items container */
        .menu-items {
       display:flex-sodium_crypto_box;
          /* Allow items to wrap into multiple rows */
            justify-content: space-between; 
            justify:center;
           
            gap: 30px; /* Space between menu items */
           
        }
        #menu h2{
            text-align:center;
            margin:5px;
          }
          #menu      .menu-left, .menu-right {
            flex: 1; /* Each section takes half the space */
            border: 1px solid #ccc; /* Border around each section */
            border-radius: 5px;
            background-color: white; /* White background */
            padding: 15px; /* Padding within each section */
        }
        
        
        

        /* Styles for individual menu items */
       

        /* Styles for the images */
        
        

        /* Hover effect for menu items */
       

</style>
<!--Header End-->
<main>
    <!--Header start-->
    <section id="about">
        <div class="container">
            <div class="title">
                <h2> Restaurant BENI HAMAD </h2>
                <p> </p>
            </div>
            <div class="about-content">
                <div>
                    <p></p>
                    <p></p>
                    <a href="#" class="btn btn-secondary"></a>
                </div>
                <img src="./img/about_img.png" alt="pizza">
            </div>
        </div>
    </section>
    <!--Header End--> 
    <!--offers start -->
    <section id="offers">
        <div class="container">
            
            <div class="title">
                <h2>Menu  spécial </h2>
            
                
             
           
            </div>
            <div class="offers-items">
                <div>
                    <img src="./img/offer1.png" alt="quattro pasta">
                    <div>
                        <h3>Pâtes Quattro</h3>
                      
                        <p><del>500DA</del><span class="primary-text">350DA</span></p>
                    </div>
                </div>
                <div>
                    <img src="./img/offer2.png" alt="quattro pasta">
                    <div>
                        <h3>Pâtes Végétariennes</h3>
                        
                        <p><del>600DA</del><span class="primary-text">450DA</span></p>
                    </div>
                </div>
                <div>
                    <img src="./img/offer3.png" alt="quattro pasta">
                    <div>
                        <h3>Pâtes sans Gluten</h3>
                       
                        <p><del>400DA</del><span class="primary-text">300DA</span></p>
                    </div>
                </div>
                

            </div>
        </div>

    </section>
     <!--Header End-->
     <!--offers start -->
     <section id="menu">
        <div class="container">
            <div class="title">
          <h2>Menu </h2>
        
          </div>
          <?php
          // Database connection
              $con = mysqli_connect("localhost", "root", "", "hotel");

              if (!$con) {
                  die("Connection failed: " . mysqli_connect_error());
              }
                $query = "SELECT * FROM menu";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imagePath = 'img/' . $row['image'];
                            echo "
                            <div>
                                <img src=\"$imagePath\" alt=\"{$row['type']}\">
                                <div>
                                    <h3>{$row['type']} <span class=\"primary-text\">{$row['prix']}DA</span></h3>
                                   
                                </div>
                            </div>
                            ";
                        }
                          // Close database connection
                    mysqli_close($con);
                    }

                
                ?>
                <div class="menu-items">
                    
                   
                <div class="menu-items-left">
                    
  </div>
        </div>
     </section>
     <!--Header End-->
</main>
    
</body>
</html>                