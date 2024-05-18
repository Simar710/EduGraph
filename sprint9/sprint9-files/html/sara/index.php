<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sara's Page</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php
            echo '<div class="home">';
                echo '<button class="btn" tabindex="-1"><a href=\'/\'><i class="fa fa-home"></i></a></button>';
            echo '</div>';
        ?>
        <?php 
            echo '<h1>Hello, My name is Sara!</p>'; 
            //insert img
            $imagePathSaraOne = "sara.jpg"; 
            $altTextSaraOne = "Sara Photo"; 

            echo '<img src="' . $imagePathSaraOne . '" alt="' . $altTextSaraOne . '" class="sara-img">';
        ?>

        <div class="sara-split-container">
                <div class="sara-profile">
                    <?php
                    $name = "Sara";
                    $hobbies = ["Macaroons", "Brookies", "Layered Cakes"];
                    $hobbyList = "<ul>";
                    foreach ($hobbies as $hobby) {
                        $hobbyList .= "<li>$hobby</li>";
                    }
                    $hobbyList .= "</ul>";

                    $jokes = ["What did the computer do at lunch time? HAD A BYTE", "Why did the programmer quit his job? HE DIDN'T GET ARRAYS!", "What did Javascript say to the HTML? YOU BETTER BRACE YOURSELF!"];
                    $jokeList = "<ul>";
                    foreach ($jokes as $joke) {
                        $jokeList .= "<li>$joke</li>";
                    }
                    $jokeList .= "</ul>";

                    ?>
                    <p>Hello, I'm <?php echo $name; ?>, currently an undergraduate student majoring in software engineering. Beyond my academic pursuits, I have a variety of hobbies that keep life interesting.</p>
                    <p>I find solace in the art of baking, and there's nothing quite like the satisfaction of creating delicious treats from scratch. Among my top three favorite things to bake are:</p>
                    <?php echo $hobbyList; ?>
                    <p>Long walks, reading, and diving into the world of YouTube also fill my free time and provide a much-needed break from coding and coursework. <br><br>One interesting fact about me is that I'm on a journey to become a certified personal trainer. I've been hitting the gym and weightlifting for nearly two and a half years now, and it's been an incredible journey of self-improvement and discipline. Balancing my technical studies with these diverse interests helps me stay motivated and well-rounded. So, whether I'm writing code or perfecting a new recipe, you can always find me enthusiastically embracing life's challenges.</p>
                    <p>Some funny programming jokes:</p>
                    <?php echo $jokeList; ?>

                </div>
                <div class="sara-right-section">
                    <?php
                    $imageUrls = [
                        'sara-one.jpeg',
                        'sara-two.jpeg',
                        'sara-three.jpeg',
                        'sara-four.jpeg',
                    ];

                    // Define the number of columns in the grid
                    $columns = 2;

                    for ($i = 0; $i < count($imageUrls); $i++) {
                        // Start a new row div for the first column
                        if ($i % $columns === 0) {
                            echo '<div class="sara-column">';
                        }
                
                        echo '<img src="' . $imageUrls[$i] . '" alt="Image ' . ($i + 1) . '">';
                
                        // Close the row div for the last column or at the end of the loop
                        if ($i % $columns === $columns - 1 || $i === count($imageUrls) - 1) {
                            echo '</div>';
                        }
                    }
                    ?>

                </div>
            </div>
        
    </body>
</html>
