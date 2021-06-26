<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }
    $eposta = $_SESSION['KULLANICI_ADI'];
    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');

    $sorgu2 = $con -> prepare('SELECT id FROM teacher WHERE teacher_email=?');
    $sorgu2 -> execute([$eposta]);
    $icerik = $sorgu2 -> fetch(PDO::FETCH_ASSOC);
    $teacherId = $icerik['id'];

    $sorgu3 = $con -> prepare('SELECT teacher_name FROM teacher WHERE id=?');
    $sorgu3 -> execute([$teacherId]);
    $icerik2 = $sorgu3 -> fetch(PDO::FETCH_ASSOC);
    $teacherName = $icerik2['teacher_name'];

    $sorgu = $con -> prepare('SELECT * FROM project WHERE ogretmen_id=?');
    $sorgu -> execute([$teacherId]);
    $odevler = $sorgu -> fetchAll(PDO::FETCH_ASSOC);
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <style type="text/css">
        th{text-align:left;}
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Anasayfa</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="icerik.php">Anasayfa</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
      </div>
    </div>
  </div>
</nav>

    <div class="container pt-5">
        <div class="d-flex">
            <h1 class="me-auto">PROJE</h1>
            <div>
                <a class="btn btn-success" href="odevEkle.php"><i class="fas fa-plus"></i> Proje Ekle</a>
            </div>    
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ÖĞRETMEN ADI</th>
                    <th>PROJE ADI</th>
                    <th>PROJE ANAHTAR KELİMELER</th>
                    <th>PROJE İÇERİĞİ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($odevler as $key => $value){  ?>
                        <tr>
                            <td><?=$value['id'] ?></td>
                            <td><?=$teacherName?></td>
                            <td><?=$value['proje_isim'] ?></td>
                            <td><?=$value['proje_keyword'] ?></td>
                            <td><?=$value['proje_icerik'] ?></td>
                            <td class="text-end">
                              <a class="btn btn-sm btn-primary" href="odevDuzenle.php?odev_no=<?=$value['id'] ?>">
                              <i class="fas fa-edit"></i> Düzenle</a>
                              <a class="btn btn-sm btn-danger" href="odevSil.php?odev_no=<?=$value['id'] ?>"><i class="fas fa-trash"></i> Sil</a>
                            </td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <nav class="navbar fixed-bottom navbar-light bg-light">
  <div class="container">
    <span class="text-muted"><i class="far fa-copyright"></i>Copyright <?=date('Y')?></span>
  </div>
</nav>
</body>
</html>