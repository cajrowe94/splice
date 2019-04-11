<?php
  $table = $_POST['data'];
  file_put_contents("../data/".$_GET['user']."/table.json", $table);
  //print_r($table);
