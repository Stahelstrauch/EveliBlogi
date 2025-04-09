<?php
if(isset($_GET['sid']) && is_numeric($_GET['sid'])) {
    $id = (int)$_GET['sid']; // Võtame url id väärtuse tehes täisarvuks
    $sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as adding from blog where id = ".$id;
    $data = $db->dbGetArray($sql);

    if($data !== false) {
       $val = $data[0]; 


?>
            <h2><?= $val['heading']; ?></h2>
            <p><?= $val['adding']; ?></p>
                <p><?= $val['context']; ?></p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo $val['photo']; ?>" class="img-fluid" alt="Hel1">
                        </div>
                        </div>
                        </div>
                    </div>
                <p><?php 
                    $tags = array_map('trim', explode(",", $val['tags'])); // Tükelda sildid komast 
                    // $db->show($tags); //TEST
                    $links = []; // Tühi linkide list
                    foreach($tags as $tag) {
                        $safeTag = htmlspecialchars($tag); //Turvaline html
                        $links[] = "<a href=''>{$safeTag}</a>";
                    }
                    $result = implode(",", $links); // Ühenda listi elemendid komaga
                    echo $result; // väljasta tulemus
                    // $db->show($links); //Test
                    ?>

                </p>
                <p>
        <div class="container-fluid bg-success p-3 text-white">
            <div class="row">
                <div class="col-md-6">
                        <a class="nav-link disabled text-start fw-bold">Eelmine postitus</a>
                    </div>
                    <div class="col-md-6">
                         <a class="nav-link text-end fw-bold" href="?page=post2">Järgmine postitus</a>
                    </div>
                </div>
            </div>
<?php
    } else {
        ?>
        <h4>Viga</h4>
        <p>Sellist postitust ei ole!</p>
        <?php

    }


}  else {
    ?>
    <h4>Viga</h4>
    <p>URL on vigane!</p>
    <?php
}
?>               
                