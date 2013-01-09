<?php
include 'common.php';
$stm = $db->prepare('delete from urls where url = :url ');
$stm->bindValue(':url', $_GET['url'], PDO::PARAM_STR);
$stm->execute();

header('Location: index.php');
?>
