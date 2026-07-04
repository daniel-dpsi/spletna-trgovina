<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['kosarica'])) {
    $_SESSION['kosarica'] = array();
}

if (isset($_GET['akcija']) && $_GET['akcija'] == 'izprazni') {
    $_SESSION['kosarica'] = array();
    header("Location: kosarica.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaša Košarica - E-Trgovina</title>
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
        <h2>Pregled vaše nakupovalne košarice</h2>

        <?php
        if (!empty($_SESSION['kosarica'])) {
            $id_vsi = implode(',', array_keys($_SESSION['kosarica']));
            
            $sql = "SELECT * FROM izdelki WHERE id IN ($id_vsi)";
            $rezultat = $conn->query($sql);
            
            $skupno_za_placilo = 0;
            ?>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; border: 1px solid #eaeaea; border-radius: 8px;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 1px solid #eaeaea; text-align: left;">
                        <th style="padding: 15px;">Izdelek</th>
                        <th style="padding: 15px;">Cena</th>
                        <th style="padding: 15px;">Količina</th>
                        <th style="padding: 15px;">Skupaj</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($izdelek = $rezultat->fetch_assoc()) {
                        $kolicina = $_SESSION['kosarica'][$izdelek['id']];
                        $vmesni_skupni_znesek = $izdelek['cena'] * $kolicina;
                        $skupno_za_placilo += $vmesni_skupni_znesek;
                        ?>
                        <tr style="border-bottom: 1px solid #eaeaea;">
                            <td style="padding: 15px; font-weight: 500;"><?php echo htmlspecialchars($izdelek['ime']); ?></td>
                            <td style="padding: 15px;"><?php echo number_format($izdelek['cena'], 2, ',', '.'); ?> €</td>
                            <td style="padding: 15px;"><?php echo $kolicina; ?></td>
                            <td style="padding: 15px; font-weight: 600;"><?php echo number_format($vmesni_skupni_znesek, 2, ',', '.'); ?> €</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr style="background: #fafafa; font-size: 1.1rem; font-weight: 700;">
                        <td colspan="3" style="padding: 20px; text-align: right;">Skupaj za plačilo:</td>
                        <td style="padding: 20px; color: #111;"><?php echo number_format($skupno_za_placilo, 2, ',', '.'); ?> €</td>
                    </tr>
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="kosarica.php?akcija=izprazni" style="color: #ff3333; text-decoration: none; font-size: 0.9rem;">Izprazni košarico</a>
                <a href="narocilo.php" style="background: #111; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: 500; transition: background 0.2s;">Nadaljuj na naročilo</a>
            </div>

            <?php
        } else {
            echo "<p style='color: #666;'>Vaša košarica je trenutno prazna. Nazaj na <a href='index.php' style='color:#111; font-weight:600;'>ponudbo</a>.</p>";
        }
        ?>
    </main>

    <footer>
        <div class="kontejner">
            <p>&copy; <?php echo date("Y"); ?> Avtomatizirana spletna trgovina - Daniel Grozdanović</p>
        </div>
    </footer>

</body>
</html>