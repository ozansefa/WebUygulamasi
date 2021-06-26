<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    $odev_no = $_GET['odev_no'] ?? null;
    if(!$odev_no){
        header('location:index.php');
        exit();
    }

    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
    $eposta = $_SESSION['KULLANICI_ADI'];
    
    $sorgu2 = $con -> prepare('SELECT id FROM student WHERE std_email=?');
    $sorgu2 -> execute([$eposta]);
    $icerik = $sorgu2 -> fetch(PDO::FETCH_ASSOC);
    print_r($icerik);
    $studentId = $icerik['id'];
    

    $sorgu = $con -> prepare('UPDATE project SET ogrenci_id=? WHERE id=?');
    $sorgu -> execute([$studentId, $odev_no]);
    header('location: icerik.php');
    exit();