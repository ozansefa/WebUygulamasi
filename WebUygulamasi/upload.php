<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   
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
            //echo "success";
        }
        else{
            echo "error".mysqli_error($conn);
        }
        
    }
    
    ?>
   
   <table border="1px" align="center">
       <tr>
           <td>
               <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="rapor_adi" placeholder="rapor adı">
                    <input type="text" name="rapor_keyword" placeholder="anahtar kelimeler">
                    <input type="file" name="file">
                    <button type="submit" name="submit"> Upload</button>
                </form>
           </td>
       </tr>
       <tr>
           <td>
              <?php
               $query2 = "SELECT * FROM raporlar";
               $run2 = mysqli_query($conn,$query2);
               
               while($rows = mysqli_fetch_assoc($run2)){
                   ?>
               <a href="download.php?file=<?php echo $rows['rapor_icerik'] ?>">Download</a><br>
               <?php
               }
               ?>
           </td>
       </tr>
   </table>
    
</body>
</html>
