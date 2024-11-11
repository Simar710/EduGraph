<?php $pageTitle="Emily's page"?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      <?php include "index.css" ?>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Merriweather:wght@300&display=swap" rel="stylesheet">

    <title><?php echo $pageTitle; ?></title>
</head>
<body>

    <?php
        echo '<div class="home">';
            echo '<button class="btn" tabindex="-1"><a href=\'/\'><i class="fa fa-home"></i></a></button>';
        echo '</div>';
    ?>

    <main>
        <?php
            $name = "Emily";
            $education = "Bachelor of Computing at the University of Guelph";
            $year = "fourth year";
            $linkedin = "https://www.linkedin.com/in/johndoe/";

            //insert img
            $imagePath = "emily.png"; 
            $altText = "Emily Profile";
        ?>

        <h1> Nice to meet you. I'm <?php echo $name; ?>.<h1>
        <img src="<?php echo $imagePath; ?>" alt="<?php echo $altText; ?>" class="emily-img">

        <div class=text-container>
            <p>While pursuing my <?php echo $education; ?> in the midst of my <?php echo $year; ?>, I grow constantly. Taking CIS*3760, I am part of
            a team that produced VBA scripts for a course recommender in excel.<p>

            <?php
            echo "<p>My hobbies are: ";
            $hobbies = array("gaming", "tennis", "reading", "photography");

            foreach ($hobbies as $hobby) {
                echo "$hobby, ";
            }
            echo "and of course, constantly coding.";
            ?>

            <p>One very interesting fact about myself is that I love to travel, and take my camera with me! I've been working on building
                a solid portfolio throughout my life, and trying to develop my passion for documenting where I've gone in my life. I try 
                to incorporate creativity in all aspects of my life, and work on becoming the best version of myself. <p>
        <div>


    </main>

    <div class="photo-container">
        <?php
            $photographs = array('tennis.jpg', 'banff.jpg', 'bee.jpg', 'grass.JPG');

            foreach ($photographs as $image) {
                echo '<div class="photo"><img class="photo" src="' . $image . '" alt="Photo"></div>';
            }
        ?>

    </div>
</body>
</html>
