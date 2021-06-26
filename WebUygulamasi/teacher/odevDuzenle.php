<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $odev_no = $_GET['odev_no'] ?? null; 
        if(!$odev_no){
            header('location:ogretmen.php');
            exit();
        }
        $sorgu = $con -> prepare('SELECT * FROM project WHERE id=?');
        $sorgu -> execute([$odev_no]);
        $icerik = $sorgu -> fetch(PDO::FETCH_ASSOC);
        if(!$icerik){
            header('location:ogretmen.php');
            exit();
        }
    }

    else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $no = $_POST['no'] ?? null;
        $ogr_adi = $_POST['ogr_adi'] ?? null;
        $odev_adi = $_POST['odev_adi'] ?? null;
        $odev_anahtar = $_POST['odev_anahtar'] ?? null;
        $odev_icerigi = $_POST['odev_icerigi'] ?? null;
        
        if(!$no){
            header('location:ogretmen.php');
            exit();
        }
        $sorgu = $con -> prepare('UPDATE project SET proje_isim=?, proje_keyword=?, proje_icerik=? WHERE id=?');
        $sorgu -> execute([$odev_adi, $odev_anahtar, $odev_icerigi, $no]);
        header('Location:ogretmen.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proje Düzenle</title>
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
    <a class="navbar-brand" href="#">PROJE-DUZENLEME-SAYFASI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="ogretmen.php">Anasayfa</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
      </div>
    </div>
  </div>
</nav>

    <div class="container pt-5">
        <div class="d-flex">
            <h1 class="me-auto">Proje Düzenle</h1>
            <div>
                <a class="btn btn-success" href="ogretmen.php"><i class="fas fa-backward"></i></i> Geri Gel</a>
            </div>    
        </div>
        <form action="odevDuzenle.php" method="POST">
        <input type="hidden" name="no" value="<?=$icerik['id']?>">
          <div class="mb-3">
              <label>Proje Adı</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="odev_adi" required value="<?=$icerik['proje_isim']?>">
          </div>
          <div class="mb-3">
              <label>Anahtar Kelimeler</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="odev_anahtar" required value="<?=$icerik['proje_keyword']?>">
          </div>
          <div class="mb-3">
              <label>Proje İçerigi</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="odev_icerigi" required style="min-height: 150px;"  value="<?=$icerik['proje_icerik']?>">
          </div>
          <button class="btn btn-primary btn-lg w-100">Gönder</button>
        </form>


    <nav class="navbar fixed-bottom navbar-light bg-light">
  <div class="container">
    <span class="text-muted"><i class="far fa-copyright"></i>Copyright <?=date('Y')?></span>
  </div>
</nav>
</body>
</html>