<?php
if(isset($_GET['sid']) && is_numeric($_GET['sid'])) {
    $id = (int)$_GET['sid']; // Võtame url id väärtuse tehes täisarvuks
    $sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as adding from blog where id = ".$id;
    $data = $db->dbGetArray($sql);

    if($data !== false) {
       $val = $data[0]; 

       $sql_prev = "SELECT id from blog where added > '". $val['added'] . "' ORDER BY added asc LIMIT 1";
       $prev = $db->dbGetArray($sql_prev);
       $sql_next = "SELECT id FROM blog WHERE added < '". $val['added'] . "' ORDER BY added desc LIMIT 1";
       $next = $db->dbGetArray($sql_next);
       // echo $prev[0]['id']." ".$next[0]['id'];


?>
            <h2><?= $val['heading']; ?></h2>
            <p><?= $val['adding']; ?></p>
                <p><?= $val['context']; ?></p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo $val['photo']; ?>" class="img-fluid" alt="Hel1">
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
        <div class="container bg-success p-3 text-white">
            <div class="row">
                <?php
                // EElmine nupp
                if($prev !== false){
                    ?>
                    <div class="col-md-6">
                        <a class="nav-link text-center fw-bold" href="?page=post&sid=<?=$prev[0]['id']; ?>">Eelmine postitus</a>
                    </div>
                    <?php
                }
                // Järgmine postitus
                if($next !== false){
                    ?>
                    <div class="col-md-6">
                         <a class="nav-link text-center fw-bold" href="?page=post&sid=<?=$next[0]['id']; ?>">Järgmine postitus</a>
                    </div>
                    <?php
                }
                ?>
                
                    
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
                