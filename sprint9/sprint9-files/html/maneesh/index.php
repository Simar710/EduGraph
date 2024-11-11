<?php
    $pageTitle = "Hi, I'm Maneesh";

    $sections = [
        [
            "content" => "I'm currently majoring in Computer Science and I'm passionate about developing software along with always being curious to learn new technologies in the industry. I program a ton whether it be fullstack applications, code katas, and just random ideas that come to mind."
        ],
        [
            "content" => "Apart from programming, I also love to stay active by going climbing whether it's the crag in the area or a local gym. As of now, I mainly focus on bouldering and I've been doing it for around a year with my PB being V8 (7B). Overall, I greatly enjoy the problem-solving aspect of figuring out a boulder problem and being able to push myself physically is an added bonus."
        ],
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
      <?php include "index.css" ?>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        echo '<div class="home">';
            echo '<button class="btn" tabindex="-1"><a href=\'/\'><i class="fa fa-home"></i></a></button>';
        echo '</div>';
    ?>
    <main>
        <div class="portrait-container">
            <header>
                <h1><?php echo $pageTitle; ?></h1>
            </header>
            <div class="portrait">
                <?php
                    $img = "maneesh1.jpg";
                    echo '<img src="' . $img .'">'
                ?>
            </div>
        </div>
        <div class="intro-container">
            <div class="intro-left">
                <?php
                    for ($i = 0; $i < count($sections); $i++) {
                        echo "<p>" . $sections[$i]["content"] . "</p>";
                        echo "<br>";
                    } 
                ?>
            </div>
            <div class="intro-right">
                <?php 
                    $img2 = "maneesh2.jpg";
                    echo '<img src="' . $img2 .'">';
                    echo "<p>" . "Niagra Glen" . "</p>";
                ?>
            </div>
        </div>
    </main>
</body>
</html>

