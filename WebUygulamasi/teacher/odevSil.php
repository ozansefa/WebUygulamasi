<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    $odev_no = $_GET['odev_no'] ?? null;
    if(!$odev_no){
        header('location: ogretmen.php');
        exit();
    }

    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
    $sorgu = $con -> prepare('DELETE FROM project WHERE id=?');
    $sorgu -> execute([$odev_no]);
    header('location: ogretmen.php');
    exit();
    
