<?php
$sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y') as estonia from blog order by added desc";
$data = $db->dbGetArray($sql);

if($data !== false) {
  $counter = 0; // Veeru lugeja 1,2 või 3
  foreach($data as $post) {
    if($counter % 3 === 0) { //jagamine jäägiga, mod, peab olema jagamisel täisarv
      ?>
      <div class="row g-1">
      <?php
    } // $counter % 3 === 0
    ?>
    <div class="col-md-4">
      <div class="card">
        <img src=<?= $post['photo']; ?> class="card-img-top img-fluid" alt="Polar">
        <div class="card-body">
          <h2 class="card-title orange-heading text-center"><?= $post['heading']; ?></h2>
          <p class="text-center"><?= $post['estonia']; ?></p>
          <p class="card-text"><?= $post['preamble']; ?></p>
          <a href="?page=post&sid=<?=$post['id']; ?>" class="btn btn-success">Loe edasi...</a>
        </div>
      </div>
    </div>

    <?php
    $counter++; // Liida üks juurde
    if($counter % 3 === 0) {
      echo "</div>"; // Rea lõpp
    }

  } //foreach
  if($counter % 3 === 0) {
    echo "</div>"; // Rea lõpp, kui viimasel real on postitusi
  }
} // $data !== false


?>
