<?php

session_start();
if(empty($_SESSION['KULLANICI_ADI'])){
    Header('Location:index.php');
    exit();
}
    // (B) PROCESS SEARCH WHEN FORM SUBMITTED
    if (isset($_POST['search'])) {
      // (B1) SEARCH FOR USERS
      // (A) DATABASE CONFIG - CHANGE TO YOUR OWN!
define('DB_HOST', 'localhost');
define('DB_NAME', 'site-veritabani');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// (B) CONNECT TO DATABASE
try {
  $pdo = new PDO(
    "mysql:host=".DB_HOST.";charset=".DB_CHARSET.";dbname=".DB_NAME,
    DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
} catch (Exception $ex) { exit($ex->getMessage()); }
  
// (C) SEARCH
$stmt = $pdo->prepare("SELECT r.id, r.rapor_adi, r.rapor_keyword, r.rapor_icerik, s.std_name FROM raporlar r INNER JOIN student s on r.ogrenci_id=s.id WHERE r.rapor_keyword LIKE ?");
//$stmt = $pdo->prepare("SELECT * FROM `raporlar` WHERE `rapor_keyword` LIKE ?");
$stmt->execute(["%".$_POST['search']."%"]);
$results = $stmt->fetchAll();

//$sorgu = $con -> prepare('SELECT r.id, r.rapor_adi, r.rapor_keyword, r.rapor_icerik, s.std_name FROM raporlar r INNER JOIN student s on r.ogrenci_id=s.id WHERE r.rapor_keyword LIKE ?');
}
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
    <a class="navbar-brand" href="#">RAPORLAR-SAYFASI</a>
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
            <h1 class="me-auto">PROJELER</h1>
            <div>
                <a class="btn btn-success" href="index.php">Geri Dön</a>
            </div>    
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ÖĞRENCİ ADI</th>
                    <th>RAPOR ADI</th>
                    <th>ANAHTAR KELİMELER</th>
                    <th>RAPORUN İÇERİĞİ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($results as $key => $value){  ?>
                        <tr>
                            <td><?=$value['id'] ?></td>
                            <td><?=$value['std_name']?></td>
                            <td><?=$value['rapor_adi'] ?></td>
                            <td><?=$value['rapor_keyword'] ?></td>
                            <td><?=$value['rapor_icerik'] ?></td>
                            <td><a href="download.php?file=<?php echo $value['rapor_icerik'] ?>">Download</a><br></td>
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