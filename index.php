<?php
include("include/settings.php"); // Lae seaded
include("include/mysqli.php"); // Lae andmebaasi klass
$db= new Db(); // Loo andmebaasi objekt

$page = isset($_GET['page']) ? $_GET['page'] : 'homepage';
$allowed_pages = ['homepage', 'menu', 'blogi', 'kontakt', 'post', 'post_add', 'post_edit', 'edit'];
if(!in_array($page, $allowed_pages)){
    $page = 'homepage';
}

$headlines = [
    'homepage' => 'Eveli Blogi',
    'blogi' => 'Blogi',
    'kontakt' => 'Kontakt',
    'post' => 'Postitus',
    'post_add' => "Lisa",
    'post_edit' => "Muuda",
    'edit' => "Postituste muutmine"
];

$headline = isset($headlines[$page]) ? $headlines[$page] : 'Eveli Blogi';

$subtexts = [
    'homepage' => 'Tere sõber või võõras!<br>
                See on minu esimene ja loodetavasti mitte viimane blogilehekülg.<br>
                Kui sa tulid siia, et midagi asjalikku lugeda, siis pead kahjuks pettuma!',
    'blogi' => ' ',
    'kontakt' => ' ',
    'post_add' => ' ',
    'post_edit' => ' ',
    'edit' => ' '
    
];

$subtext = isset($subtexts[$page]) ? $subtexts[$page] : $subtexts['homepage'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
