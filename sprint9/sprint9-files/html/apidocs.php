<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700:wght@400;700&display=swap" rel="stylesheet">
    <style>
      <?php include "index.css" ?>
    </style> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: auto;
            max-width: 100%;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h1, h2, h3 {
            font-weight: 700;
            color: #007bff;
            margin-bottom: 10px;
        }
        .section {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: box-shadow 0.3s ease;
        }
        .section:nth-child(even) {
            background-color: #f9f9f9;
        }
        .section:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .codebox {
            display: block;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f8f9fa;
            padding: 15px;
            margin-top: 10px;
            overflow-x: auto;
        }
        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }
        p {
            line-height: 1.6;
        }
        code {
            background-color: #f8f9fa;
            padding: 2px 5px;
            border-radius: 5px;
            font-family: 'Courier New', Courier, monospace;
        }
        @media (max-width: 768px) {
            .section {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="home">
        <a href="/" aria-label="Home"><button class="btn-home" aria-label="home button" tabindex="-1"><i class="fa fa-home"></i></button></a>
    </div>

    <?php
    // Function to convert Markdown to HTML
    function markdownToHtml($markdown) {
        // Convert headers
        $markdown = preg_replace('/\#\#\# (.+)/', '<h3>$1</h3>', $markdown);
        $markdown = preg_replace('/\#\# (.+)/', '<h2>$1</h2>', $markdown);
        $markdown = preg_replace('/\# (.+)/', '<h1>$1</h1>', $markdown);

        // Convert paragraphs and horizontal rules
        $markdown = preg_replace('/\n\n/', '</p><p>', $markdown);
        $markdown = preg_replace('/---/', '<hr>', $markdown);

        // Line breaks to <br>
        $markdown = preg_replace('/\n/', '<br>', $markdown);

        // Convert ** to bold tags
        $markdown = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $markdown);

        // Convert triple backticks for code blocks (covers multiple lines)
        $markdown = preg_replace('/```(.*?)```/s', '<div class="codebox"><pre><code>$1</code></pre></div>', $markdown);

        // Convert single backticks for inline code
        $markdown = preg_replace('/`(.*?)`/', '<code>$1</code>', $markdown);

        // Convert links
        $markdown = preg_replace('/[?:>]?(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $markdown);

        return $markdown;
    }

    // Read the Markdown file
    $markdownContent = file_get_contents('API.md');

    // Convert Markdown to HTML
    $htmlContent = markdownToHtml($markdownContent);

    // Display the HTML content
    echo '<div class="section">' . $htmlContent . '</div>';
    ?>
</body>
</html>
