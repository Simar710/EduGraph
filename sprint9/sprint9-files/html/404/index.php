<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            animation: fadeInUp 1s ease both;
        }

        h1 {
            font-size: 4rem;
            color: #333;
            margin-bottom: 20px;
            animation: bounceIn 0.5s ease both;
        }

        p {
            font-size: 1.2rem;
            color: #777;
            animation: fadeIn 1s ease 1.2s both;
        }

        .back-link {
            margin-top: 20px;
            animation: fadeIn 1s ease 1.4s both;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404 - Page Not Found</h1>
        <?php
            echo "<p>Sorry, the page <strong>{$_SERVER["REQUEST_URI"]}</strong> could not be found.</p>";
            echo "<p class=\"back-link\">Return to <a href=\"/\">home</a></p>";
        ?>
    </div>
</body>
</html>

