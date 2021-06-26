<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "site-veritabani";
    $output = '';
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    if(isset($_POST['search'])){
        $searchq = $_POST['search'];
        $sorgu = 'SELECT * FROM raporlar WHERE rapor_keyword LIKE "%$searchq%"';
        $query = mysqli_query($conn, $sorgu);
        print_r($query);
        $count = mysqli_num_rows($query);
        if($count == 0){
            $output = "Herhangi bir sonuc yok";
        }
        else{
            while($row = mysqli_fetch_array($query)){
                $id = $row['id'];
                $rname = $row['rapor_adi'];
                $content = $row['rapor_icerik'];

                $output .= '<div> '.$rname.' '.$content.'</div>';
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
    <form action="search2.php" method="POST">
        <input type="text" name="search" placeholder="Rapor Ara">
        <input type="submit" value=">>">
    </form>

<?php print("$output");?>


</body>
</html>