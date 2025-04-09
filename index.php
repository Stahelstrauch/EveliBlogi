<?php
include("include/settings.php"); // Lae seaded
include("include/mysqli.php"); // Lae andmebaasi klass
$db= new Db(); // Loo andmebaasi objekt

$page = isset($_GET['page']) ? $_GET['page'] : 'homepage';
$allowed_pages = ['homepage', 'menu', 'blogi', 'kontakt', 'post', 'post_add'];
if(!in_array($page, $allowed_pages)){
    $page = 'homepage';
}

$headlines = [
    'homepage' => 'Eveli Blogi',
    'blogi' => 'Blogi',
    'kontakt' => 'Kontakt',
    'post1' => 'Helmikpööris "Silver Gumdrop"',
    'post2' => 'Hosta "Blue Ivory"',
    'post3' => 'Astilbe "Look at me"',
    'post4' => 'Tähiklavendel "Munstead"',
    'post5' => 'Aedhortensia "Polar Bear"',
    'post_add' => "Lisa"
];

$headline = isset($headlines[$page]) ? $headlines[$page] : 'Eveli Blogi';

$subtexts = [
    'homepage' => 'Tere sõber või võõras!<br>
                See on minu esimene ja loodetavasti mitte viimane blogilehekülg.<br>
                Kui sa tulid siia, et midagi asjalikku lugeda, siis pead kahjuks pettuma!',
    'blogi' => ' ',
    'kontakt' => ' ',
    'post1' => '01.01.2025',
    'post2' => '14.01.2025',
    'post3' => '24.02.2025',
    'post4' => '14.03.2025',
    'post_add' => ' ',
    'post5' => '27.03.2025'
];

$subtext = isset($subtexts[$page]) ? $subtexts[$page] : $subtexts['homepage'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title><?php echo $headline; ?></title>
</head>
<body>
    <div class="container">
        <div class="container-fluid p-5 bg-success text-white text-center">
            <h1><?php echo $headline; ?></h1>
            <p><?php echo $subtext; ?></p>
        </div>
        <?php include 'menu.html'; ?>
    </div>

    <div class="container">
        <?php include "$page.php"; ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>   
</body>
</html>
