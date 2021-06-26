
<?php
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
$stmt = $pdo->prepare("SELECT * FROM `raporlar` WHERE `rapor_keyword` LIKE ?");
$stmt->execute(["%".$_POST['search']."%"]);
$results = $stmt->fetchAll();
if (isset($_POST['ajax'])) { echo json_encode($results); }
      
      // (B2) DISPLAY RESULTS
      if (count($results) > 0) {
        foreach ($results as $r) {
          printf("<div>%s - %s</div> - %s</div>", $r['id'], $r['rapor_adi'], $r['rapor_keyword']);
        }
      } else { echo "No results found"; }
    }
?>
