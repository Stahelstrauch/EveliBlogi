<?php
$sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%I:%s') as estonia from blog order by added desc limit 3";
$data = $db->dbGetArray($sql);
// $db->show($data); // Test näitab  kirjeid

?>
<div class="container mt-5">
  <div class="row">
<?php
if($data !== false) { //Leiti andmeid
  foreach($data as $key=>$val) {
    ?>
    <!--SIIA HTML osa -->
    <div class="col-sm-4">
      <h2 class="text-center orange-heading"><?php echo $val['heading']; ?></h2>
      <p><?php echo $val['estonia']; ?></p>
      <p><img src="<?php echo $val['photo']; ?>" class="img-fluid" alt="Pilt"></p>
      <p><?php echo $val['preamble']; ?></p>


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
      ?></p>
      <p><a class="btn btn-success" href="?page=post&sid=<?=$val['id']; ?>">Loe edasi...</a></p>
    </div>
    <?php
  }
} else {
  echo "Andmeid pole!";
}

?>
    
  </div>
</div>
<div class="container-fluid p-5 bg-success text-white text-center">
    <div class="lingid">
        <a class="nav-link" href="?page=blogi">Blogi</a>
        <a class="nav-link" href="?page=kontakt">Kontakt</a>

  </div>
</div>

