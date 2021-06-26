<?php
        session_start();
        if(empty($_SESSION['KULLANICI_ADI'])){
            Header('Location:index.php');
            exit();
        }

    $con = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
    $conn = mysqli_connect('localhost','root','','site-veritabani');
    if(isset($_POST['submit'])){
        $rapor_id = $_POST['rapor_adi'];
        $rapor_keyword = $_POST['rapor_keyword'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $path = "files/".$fileName;

        $eposta = $_SESSION['KULLANICI_ADI'];
        $sorgu2 = $con -> prepare('SELECT id FROM student WHERE std_email=?');
        $sorgu2 -> execute([$eposta]);
        $icerik = $sorgu2 -> fetch(PDO::FETCH_ASSOC);
        $ogrId = $icerik['id'];
        
        $query = "INSERT INTO raporlar(rapor_adi, rapor_keyword, rapor_icerik, ogrenci_id) VALUES ('$rapor_id', '$rapor_keyword', '$fileName', '$ogrId')";
        $run = mysqli_query($conn,$query);
        
        if($run){
            move_uploaded_file($fileTmpName,$path);
            Header('Location:icerik.php');
            //echo "success";
        }
        else{
            echo "error".mysqli_error($conn);
        }
        
    }
    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proje Ekle</title>
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
    <a class="navbar-brand" href="#">RAPOR EKLE</a>
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
            <h1 class="me-auto">Rapor Ekle</h1>
            <div>
                <a class="btn btn-success" href="icerik.php"><i class="fas fa-backward"></i></i> Geri Gel</a>
            </div>    
        </div>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
              <label>Rapor Adı</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="rapor_adi" required>
          </div>
          <div class="mb-3">
              <label>Rapor Anahtar Kelimeler</label><span class="text-danger"></span>
              <input class="form-control" type="text" name="rapor_keyword" required>
          </div>
          <div class="mb-3">
              <label>Rapor İçerigi</label><span class="text-danger"></span>
              <input class="form-control" type="file" name="file" required style="min-height: 150px;">
          </div>
          <button name="submit" class="btn btn-primary btn-lg w-100">Yükle</button>
        </form>


    <nav class="navbar fixed-bottom navbar-light bg-light">
  <div class="container">
    <span class="text-muted"><i class="far fa-copyright"></i>Copyright <?=date('Y')?></span>
  </div>
</nav>

</body>
</html>