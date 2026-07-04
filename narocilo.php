<?php
require_once 'config.php';

session_start();

if (empty($_SESSION['kosarica'])) {
    header("Location: index.php");
    exit();
}

$uspesno_oddano = false;

if (isset($_POST['odday_narocilo'])) {
    $ime = $conn->real_escape_string($_POST['ime']);
    $priimek = $conn->real_escape_string($_POST['priimek']);
    $naslov = $conn->real_escape_string($_POST['naslov']);
    $posta = $conn->real_escape_string($_POST['posta']);

    $sql_narocilo = "INSERT INTO narocila (ime_kupca, priimek_kupca, naslov, posta) VALUES ('$ime', '$priimek', '$naslov', '$posta')";
    
    if ($conn->query($sql_narocilo) === TRUE) {
        $id_novega_narocila = $conn->insert_id;

        foreach ($_SESSION['kosarica'] as $izdelek_id => $kolicina) {
            $izdelek_id = intval($izdelek_id);
            $kolicina = intval($kolicina);
            
            $sql_postavka = "INSERT INTO postavke_narocila (narocilo_id, izdelek_id, kolicina) VALUES ($id_novega_narocila, $izdelek_id, $kolicina)";
            $conn->query($sql_postavka);
        }

        $_SESSION['kosarica'] = array();
        $uspesno_oddano = true;
    } else {
        echo "Napaka pri oddaji naročila: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaključek nakupa - E-Trgovina</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="kontejner">
            <h1>E-Trgovina</h1>
            <nav>
                <a href="index.php">Ponudba</a>
                <a href="kosarica.php" class="gumb-kosarica">Košarica</a>
            </nav>
        </div>
    </header>

    <main class="kontejner" style="max-width: 600px;">
        <?php if ($uspesno_oddano): ?>
            <div style="background: #e6f4ea; color: #137333; padding: 20px; border-radius: 4px; text-align: center; border: 1px solid #ceead6;">
                <h2>Naročilo je bilo uspešno oddano!</h2>
                <p style="margin-top: 10px;">Zahvaljujemo se vam za nakup. Vaši podatki in naročeni izdelki so shranjeni v naši bazi podatkov.</p>
                <a href="index.php" style="display: inline-block; margin-top: 20px; background: #111; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 4px;">Nazaj na začetno stran</a>
            </div>
        <?php else: ?>
            <h2>Podatki za dostavo</h2>
            <p style="color: #666; margin-bottom: 20px;">Prosimo, vnesite svoje podatke za uspešen zaključek nakupa.</p>

            <form action="narocilo.php" method="post" style="background: #fff; border: 1px solid #eaeaea; padding: 30px; border-radius: 8px; gap: 20px;">
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 500; color: #111;">Ime</label>
                    <input type="text" name="ime" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 500; color: #111;">Priimek</label>
                    <input type="text" name="priimek" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 500; color: #111;">Naslov za dostavo</label>
                    <input type="text" name="naslov" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 500; color: #111;">Poštna številka in kraj</label>
                    <input type="text" name="posta" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                </div>

                <button type="submit" name="odday_narocilo" style="background: #111; color: #fff; border: none; padding: 12px; font-size: 1rem; font-weight: 600; border-radius: 4px; cursor: pointer; margin-top: 10px; transition: background 0.2s;">
                    Potrdi in oddaj naročilo
                </button>
            </form>
        <?php endif; ?>
    </main>

    <footer>
        <div class="kontejner">
            <p>&copy; <?php echo date("Y"); ?> Avtomatizirana spletna trgovina - Daniel Grozdanović</p>
        </div>
    </footer>

</body>
</html>