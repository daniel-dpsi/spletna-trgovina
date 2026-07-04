<?php
$host = 'localhost'; #sprememba na AWS host, javljen v terraform CLI
$db_user = 'rootuser'; #terraform config nastavitev user
$db_pass = 'MojeVarnoGeslo123!'; #terraform config nastavitev pass
$db_name = 'trgovina_db'; #default

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Povezava z PB ni uspela: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>