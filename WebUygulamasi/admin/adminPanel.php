<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
    $sorgu = $con -> prepare('SELECT * FROM project');
    $sorgu -> execute();
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
        <a class="nav-link" href="ogrenciOlustur.php"><i class="fas fa-sign-out-alt"></i>Öğrenci Ekle</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="ogretmenOlustur.php"><i class="fas fa-sign-out-alt"></i>Öğretmen Ekle</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
      </div>
    </div>
  </div>
</nav>



    <div class="container pt-5">
        <div class="d-flex">
            <h1 class="me-auto">Selam</h1>
            <div>
                <a class="btn btn-success" href="odevEkle2.php"><i class="fas fa-plus"></i> Odev Ekle</a>
            </div>    
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ÖĞRETMEN ADI</th>
                    <th>ÖDEV ADI</th>
                    <th>ÖDEVİN İÇERİĞİ</th>
                    <th>ANAHTAR KELİMELER</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($odevler as $key => $value){  ?>
                        <tr>
                            <td><?=$value['id'] ?></td>
                            <td><?=$value['project_name'] ?></td>
                            <td><?=$value['project_keywords'] ?></td>
                            <td><?=$value['teacher_email']?></td>
                            <td><?=$value['project_content']?></td>
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