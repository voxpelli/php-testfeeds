<?php
  print("hi");
  require_once './words.php';
  require_once './random.php';
?>

<? Random::seed(100) ?>

<? for ($i=0; $i < 10; $i++) { ?>
  <p><?= Random::num(1, 5) ?></p>
<? } ?>
