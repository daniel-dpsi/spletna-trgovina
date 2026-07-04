<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['kosarica'])) {
    $_SESSION['kosarica'] = array();
}

if (isset($_POST['dodaj_v_kosarico'])) {
    $izdelek_id = intval($_POST['izdelek_id']);
    $kolicina = intval($_POST['kolicina']);

    if ($kolicina > 0) {
        if (isset($_SESSION['kosarica'][$izdelek_id])) {
            $_SESSION['kosarica'][$izdelek_id] += $kolicina;
        } else {
            $_SESSION['kosarica'][$izdelek_id] = $kolicina;
        }
    }
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM izdelki";
$rezultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja spletna trgovina</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="kontejner">
            <h1>E-Trgovina</h1>
            <nav>
                <a href="index.php">Ponudba</a>
                <a href="kosarica.php" class="gumb-kosarica">
                    Košarica (<?php echo array_sum($_SESSION['kosarica']); ?>)
                </a>
            </nav>
        </div>
    </header>

    <main class="kontejner">
        <h2>Aktualna ponudba izdelkov</h2>
        
        <div class="mreza-izdelkov">
            <?php
            if ($rezultat->num_rows > 0) {
                while($izdelek = $rezultat->fetch_assoc()) {
                    ?>
                    <div class="kartica-izdelka">
                        <h3><?php echo htmlspecialchars($izdelek['ime']); ?></h3>
                        <p class="opis"><?php echo htmlspecialchars($izdelek['opis']); ?></p>
                        <p class="cena"><?php echo number_format($izdelek['cena'], 2, ',', '.'); ?> €</p>
                        
                        <form action="index.php" method="post">
                            <input type="hidden" name="izdelek_id" value="<?php echo $izdelek['id']; ?>">
                            <label for="kolicina-<?php echo $izdelek['id']; ?>">Količina:</label>
                            <input type="number" name="kolicina" id="kolicina-<?php echo $izdelek['id']; ?>" value="1" min="1" style="width: 50px;">
                            <button type="submit" name="dodaj_v_kosarico" class="gumb-dodaj">Dodaj v košarico</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Trenutno ni izdelkov na zalogi.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <div class="kontejner">
            <p>&copy; <?php echo date("Y"); ?> Avtomatizirana spletna trgovina - Daniel Grozdanović</p>
        </div>
    </footer>

</body>
</html>