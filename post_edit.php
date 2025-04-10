<?php
if(isset($_GET['sid']) && !empty($_GET['sid']) && is_numeric($_GET['sid']) && isset($_GET['delete'])) {
    $id = (int)$_GET['sid'];
    $update = $_GET['delete'];
    $sql = "SELECT photo from blog where id = $id";
    $photo = $db->dbGetArray($sql);
    // $db->show($photo);
    if(!empty($photo[0]['photo']) && file_exists($photo[0]['photo'])) {
        unlink($photo[0]['photo']); //Kustuta pilt
    }
    $sql = "DELETE FROM blog WHERE id = $id"; //Kirje kustutamine
    if($db->dbQuery($sql)) {
        echo "Postitus on edukalt kustutatud!";
    }else {
        echo "Midagi läks kustutamisega valesti.";
    }
    header("Location: index.php?page=post_edit");
    exit;
}


$sql = "SELECT id, heading, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as added from blog order by added desc";
$data = $db->dbGetArray($sql);
// $db->show($data); // TEST

?>
<div class="class row mt-1">
    <div class="class col-md-3"></div>
    <div class="class col-md-6">
        <?php
        if($data !== false) {
            ?>
            <table class="table table-bordered table-success" >
                <thead>
                    <tr class='text-center'>
                        <th >Jrk</th>
                        <th>Pealkiri</th>
                        <th>Lisatud</th>
                        <th>Tegevus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($x = 0; $x < count($data); $x++) { // $x+=1 või $x=$x+1 kasvab ühe kaupa
                        ?>
                            <tr>
                                <td class='text-end'><?= ($x+1).'.'; ?></td>
                                <td><?= $data[$x]['heading']; ?></td>
                                <td class='text-center'><?= $data[$x]['added']; ?></td>
                                <td class='text-center'>
                                    <a href="?page=edit&sid=<?= $data[$x]['id']; ?>" title= "Muuda seda postitust!"><i class="fa-solid fa-pen text-success me-2"></i></a>
                                    <a href="?page=post_edit&sid=<?= $data[$x]['id'] ?>&delete=true" onClick="return confirm('Kas oled kindel, et soovid kustutada?');"><i class="fa-solid fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        <?php
                    } // for-loop lõpp
                    ?>
                </tbody>

            </table>

            <?php

        } else {
            echo "<h4>Viga</h4>";
            echo "<p>Postitusi ei leitud.</p>";
        }
        ?>
    </div>
</div>