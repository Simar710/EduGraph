<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        echo '<div class="home">';
            echo '<button class="btn" tabindex="-1"><a href=\'/\'><i class="fa fa-home"></i></a></button>';
        echo '</div>';
    ?>
    <div class="container">
        <h1>Simar's Page!</h1>
        <div class="info">
            <?php
            $name = "Simardeep Singh";
            $email = "abc@uoguelph.ca";
            $phone = "(123) 456-7890";
            $address = "Unit 11, 1234 abc Street, Guelph";

            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Phone:</strong> $phone</p>";
            echo "<p><strong>Address:</strong> $address</p>";
            ?>
        </div>
        <div class="hobbies">
            <h2>My Hobbies</h2>
            <?php
            $hobbies = [
                ["name" => "Working Out", "image" => "workout.jpeg", "description" => "If you can't find me anywhere, you'll find me pumping iron at the gym. Fitness is my second name! Haha! Lift Heavy! Smah the weights! Yeahhhhhh Buddy! Light Weight!"],
                ["name" => "Drawing", "image" => "drawing.jpeg", "description" => "My artistic side shines when I'm holding a pencil. I love to draw and bring my imagination to life."],
                ["name" => "Playing Football", "image" => "football.jpeg", "description" => "Football fever is real! Catch me on the field, dribbling past defenders and scoring goals."],
            ];

            foreach ($hobbies as $hobby) {
                echo '<div class="hobby">';
                echo "<img src='{$hobby['image']}' alt='{$hobby['name']}'>";
                echo "<p>{$hobby['description']}</p>";
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
