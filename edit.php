<?php
$data = false;
if(isset($_GET['sid']) && !empty($_GET['sid']) && is_numeric($_GET['sid'])) {
    // See on muutmiseks võetud kirje
    $id = (int)$_GET['sid'];
    $sql = "SELECT * FROM blog WHERE id = $id";
    $data = $db->dbGetArray($sql);
    if(isset($_GET['update']) && $_GET['update'] == 'true' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "Siin toimub uuendamine!";
        // $db->show($_POST);
        // $db->show($_FILES);
        // Tekstiväljade olemasolu ja väljade kontroll
        $heading = trim($_POST['heading'] ?? '');
        $preamble = trim($_POST['preamble'] ?? '');
        $context = trim($_POST['context'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $oldPhoto = $_POST['oldPhoto'];
        $photoUpdate = '';

        if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['photo'];
        //Failinime normaliseerimine
            $origName = basename($image['name']); // Ainult nimi.laiend(flower.jpg)
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

            // $db->show($image).'<br>';
            // echo $origName.'<br>';
            // echo $ext.'<br>';
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif']; // Lubatud pildifailid
            if(!in_array($ext, $allowed)) {
                echo "Lubatud on ainult pildifailid: ". implode(', ', $allowed);
            }else {
                $normalizedName = preg_replace('/[^a-z0-9_\-\.]/i', '_', pathinfo($origName, PATHINFO_FILENAME));
                $filename = $normalizedName . '_' . time() . '.' . $ext;
                $targetFile = UPLOAD_IMAGES . $filename;
                // faili salvestamine
                if(move_uploaded_file($image['tmp_name'], $targetFile)) {
                    //Kustuta vana fail
                    if(!empty($oldPhoto) && file_exists($oldPhoto)) {
                        unlink($oldPhoto);
                    }
                    //Lisa uuendatava kirje juurde uus faili tee
                    $photoUpdate = ", photo = '".$db->dbFix($targetFile)."'"; //SQL lause osa!
                } else {
                    echo "Pildi üleslaadimine ebaõnnestus!";
                } // mode_upload_file
            } // !in_arrey()
        } // isset($_FILES)

        // SQL lause uuendamiseks
        $sql = "UPDATE blog SET
                heading = '".$db->dbFIX($heading)."',
                preamble = '".$db->dbFIX($preamble)."',
                context = '".$db->dbFIX($context)."',
                tags = '".$db->dbFIX($tags)."'
                $photoUpdate WHERE id = $id";

        //echo $sql;
        if($db->dbQuery($sql)) {
            echo "Postitus on edukalt uuendatud!";
        }else {
            echo "Midagi läks uuendamisega valesti.";
        }
        header("Location: index.php?page=post_edit");
        exit;
    
    } // isset($_GET['update'])
} // isset($_GET['sid'])

?>
<div class="row g-4">
    <div class="col-md-3"></div>
    <div class="col-md-4">
        <?php
        if($data !== false) {
            $data = $data[0];
            ?>
            <div class="card p-2 shadow">
            <h2 class="text-center">Muuda postitust</h2>
            <form action="?page=edit&sid=<?= $data['id']; ?>&update=true" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="heading" class="form-label fw-bold">Pealkiri</label>
                    <input type="text" name="heading" <?=  $db->htmlValue('heading', $data); ?> id="heading" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="preamble" class="form-label fw-bold">Sissejuhatus</label>
                    <textarea name="preamble" class="form-control" id="preamble" rows="3" maxlength="200" required><?= $db->htmlTextContent('preamble', $data); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="context" class="form-label fw-bold">Põhitekst</label>
                    <textarea name="context" class="form-control" id="context" rows="3" required><?= $db->htmlTextContent('context', $data); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label fw-bold">Sildid</label>
                    <input type="text" name="tags" <?=  $db->htmlValue('tags', $data); ?> id="tags" class="form-control" placeholder="Eralda komadega" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label fw-bold">Pilt</label>
                    <input type="file" name="photo" id="photo"  class="form-control">
                    <a href="<?= $data['photo']; ?>" target="_blank"><img src="<?= $data['photo']; ?>" alt="Pilt" width="50"></a>
                </div>

                <div class="d-flex justify-content-between">
                    <input type="hidden" name="oldPhoto" <?= $db->htmlValue('photo', $data); ?>>
                    <button type="submit" class="btn btn-primary">Muuda postitust</button>
                    <button type="reset" class="btn btn-warning">Tühjenda vorm</button>
                    
                </div>
            </form>
        </div>
            <?php

        }else {
            echo "Sobivat postitust ei leitud!";
        }
        ?>

    </div>
</div>