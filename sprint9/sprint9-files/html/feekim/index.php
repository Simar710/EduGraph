<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fee Kim's</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <?php
            echo '<div class="home">';
                echo '<button class="btn" tabindex="-1"><a href=\'/\'><i class="fa fa-home"></i></a></button>';
            echo '</div>';
        ?>

        <?php 
            echo "<h1> Heyyy,  Fee Kim here !! </h1>"; 

            $imagePath = "feekim.jpg"; 
            $altText = "My Profile";

            echo '<img src="' . $imagePath. '" alt="' . $altText . '" class = "image-profile">';
        ?>
    </head>

    <body>
        <?php
            $name = "Fee Kim";          
        ?>

        <?php
            echo "<p1> Welcome to my page, I'm $name currently an undergraduate student at the University of Guelph studying Computer Science. </p1>";
            echo "<p1> I enjoy watching F1 and tennis during my free time. </p1>";
            echo ""; 
            echo ""; 
        ?>

        <?php
            echo "<h2> FUN FACTS ABOUT MYSELF </h2>";
            echo "<p> - I'm an International Student coming from an island in the Indian Ocean. </p>";
            echo "<p> - I can say that I'm trilingual, I speak English, French and Mauritian Creole.</p>";
        ?>

        <h3>Gallery</h3>

        <div class="image-container">
            <?php
                // Define an array of images 
                $pictures = array(
                    "mauritius.png",
                    "sunset.png",
                    "tennis.png",
                    "beach.png"
                );

                // Loop through the image array and display each image
                foreach ($pictures as $image) {
                    echo '<img class="image" src="' . $image . '" alt="Image">';
                }
            ?>
        </div>
    </body>
</html>

