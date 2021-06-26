<?php
    session_start();
    if(empty($_SESSION['KULLANICI_ADI'])){
        Header('Location:index.php');
        exit();
    }

    if($_POST){
        
      $ogr_adi = $_POST['ogr_adi'] ?? null;
      $ogr_soyad = $_POST['ogr_soyad'] ?? null;
      $ogr_mail = $_POST['ogr_mail'] ?? null;
      $ogr_parola = $_POST['ogr_parola'] ?? null;

      $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
      $sorgu = $con -> prepare('INSERT INTO student (std_name, std_email, std_passwd) VALUES (?,?,?)');
      $sorgu -> execute([$ogr_adi, $ogr_mail, $ogr_parola]);
      header('Location:icerik.php');
      exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Öğrenci Ekle</title>
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
    <a class="navbar-brand" href="#">Öğrenci-Oluştur</a>
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
            <h1 class="me-auto">Öğrenci Ekle</h1>
            <div>
                <a class="btn btn-success" href="icerik.php"><i class="fas fa-backward"></i></i> Geri Gel</a>
            </div>    
        </div>
        <form action="ogrenciOlustur.php" method="POST">
        <div class="mb-3">
              <label>Öğrenci Adı</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="ogr_adi" required>
          </div>
          <div class="mb-3">
              <label>Öğrenci Maili</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="ogr_mail" required>
          </div>
          <div class="mb-3">
              <label>Parola</label><span class="text-danger"></span>
              <input class="form-control" type="password" name="ogr_parola" required>
          </div>
          <button class="btn btn-primary btn-lg w-100">Oluştur</button>
        </form>


    <nav class="navbar fixed-bottom navbar-light bg-light">
  <div class="container">
    <span class="text-muted"><i class="far fa-copyright"></i>Copyright <?=date('Y')?></span>
  </div>
</nav>

</body>
</html>