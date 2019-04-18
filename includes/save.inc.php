<?php
  $table = $_POST['data'];
  file_put_contents("../data/".$_GET['user']."/".$_GET['title']."_save.json", $table);
