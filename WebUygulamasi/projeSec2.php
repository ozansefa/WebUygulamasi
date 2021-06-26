<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    if($_GET){
            $odev_no = $_GET['odev_no'] ?? null;
            $ogrMail = $_SESSION['KULLANICI_ADI'];
            $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
            $sorgu2 = $con -> prepare('SELECT * FROM ogretmen WHERE ogr_mail=?');
            $sorgu2 -> execute([$ogrMail]);
            $icerik = $sorgu2 -> fetchAll(PDO::FETCH_ASSOC);
            //print_r($icerik);
            foreach($icerik as $key => $value){
                echo $value['id'] . '<br>';
                echo $value['ogr_adi'] . '<br>';
                echo $value['ogr_soyadi'] . '<br>';
                echo $value['ogr_mail'] . '<br>';
                echo $value['ogr_parola'] . '<br>';
            }
            echo $odev_no;
        }

?>