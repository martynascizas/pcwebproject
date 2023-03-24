<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once 'components/head.php';
    ?>
</head>

<body>

    <!-- db conn -->
    <?php
    require 'db.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>

    <!-- navbar -->
    <?php
    require_once 'components/nav.php';
    ?>


    <div class="container products_section">
        <!-- NESIOJAMI -->
        <h3 id="nesiojami_kompiuteriai" class="text-center mt-5">Nešiojami Kompiuteriai</h3>
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM nesiojami_kompiuteriai m 
    LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id 
    GROUP BY m.id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
<div class="col-md-4">
  <div class="card mb-3 h-100 d-flex align-items-stretch">
    <div class="card-body d-flex flex-column justify-content-between">
      <h5>' .
                        "Gamintojas: " . $row["gamintojas"] . " <br> " .
                        "Ekrano Įstrižainė: " . $row["ekrano_istrizaine"] . "\" " . "<br>" .
                        "Procesorius: " . $row["procesorius"] . "<br> " .
                        "Vaizdo Plokštė: " . $row["vaizdo_plokste"] . " <br> " .
                        "Atmintis (RAM): " . $row["ram"]  . " <br> " .
                        "Kietasis diskas (HDD): " . $row["hdd"]  . "<br>" .
                        "Prekių Kategorija: " . ' Nešiojami kompiuteriai' . "<br>" .
                        "Kaina: " . $row["kaina"] . ' EUR
             </h5>
      <div class="d-flex align-items-center justify-content-center" style="height: 100%;">';

                    $photos = explode(",", $row["photos"]);
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    foreach ($photos as $photo) {
                        echo '<img src="crud/nesiojami_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                    }
                    echo '</div>';

                    echo '
      </div>
    </div>
  </div>
</div>';
                }
            } else {
                echo "<br>nesiojami_kompiuteriai - nerasta";
            }
            ?>
        </div>

        <!-- STALINIAI -->
        <h3 id="staliniai_kompiuteriai" class="text-center mt-5">Staliniai Kompiuteriai</h3>
        <div class="row justify-content-center mb-5">
            <?php
            $sql = "SELECT m.id, m.gamintojas, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM staliniai_kompiuteriai m 
    LEFT JOIN staliniai_kompiuteriai_photos mp ON m.id = mp.staliniai_kompiuteriai_id 
    GROUP BY m.id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display monitor info
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 d-flex align-items-stretch">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo "<h5>" .
                        "Gamintojas: " . $row["gamintojas"] . "<br> " .
                        "Procesorius: " . $row["procesorius"] . " <br>" .
                        "Vaizdo Plokštė: " . $row["vaizdo_plokste"] . " <br>" .
                        "Atmintis (RAM): " . $row["ram"]  . " <br>" .
                        "Kietasis diskas (HDD): " . $row["hdd"]  . " <br>" .
                        "Prekių Kategorija: " . " Staliniai kompiuteriai " . " <br>" .
                        "Kaina: " .  $row["kaina"] . " EUR
                     </h5>";
                    // Display photos
                    echo '<div class="d-flex align-items-center justify-content-center" style="height: 100%;">';
                    $photos = explode(",", $row["photos"]);
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    foreach ($photos as $photo) {
                        echo '<img src="crud/staliniai_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<br>staliniai_kompiuteriai - nerasta";
            }
            ?>
        </div>

        <!-- MONITORIAI -->
        <h3 id="monitoriai" class="text-center mt-5">Monitoriai</h3>
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
            FROM monitoriai m 
            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
            GROUP BY m.id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display monitor info
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 d-flex align-items-stretch">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' .
                        "Gamintojas: " . $row["gamintojas"] . '<br> ' .
                        "Ekrano Įstrižainė: " . $row["ekrano_istrizaine"] . "\" " . "<br>" .
                        "Prekių Kategorija: " . " Monitoriai " . " <br>" .
                        "Kaina: " . $row["kaina"] . ' EUR
                    </h5>';
                    // Display photos
                    echo '<div class="d-flex align-items-center justify-content-center" style="height: 100%;">';
                    $photos = explode(",", $row["photos"]);
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    foreach ($photos as $photo) {
                        echo '<img src="crud/monitoriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<br>monitoriai - nerasta";
            }
            ?>
        </div>

        <!-- KOMPIUTERIU_PRIEDAI -->
        <h3 id="kompiuteriu_priedai" class="text-center mt-5">Kompiuterių priedai</h3>
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.kaina, m.gamintojas, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM kompiuteriu_priedai m 
    LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id 
    GROUP BY m.id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display monitor info
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 d-flex align-items-stretch">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' .
                        "Gamintojas: " . $row["gamintojas"] . '<br>' .
                        "Pavadinimas: " . $row["pavadinimas"] . '<br>' .
                        "Aprašymas: " . $row["aprasymas"] . '<br>' .
                        "Prekių Kategorija: " . " Kompiuterių priedai " . " <br>" .
                        "Kaina: " . $row["kaina"] . ' EUR
                    </h5>';
                    // Display photos
                    echo '<div class="d-flex align-items-center justify-content-center" style="height: 100%;">';
                    $photos = explode(",", $row["photos"]);
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    foreach ($photos as $photo) {
                        echo '<img src="crud/kompiuteriu_priedai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<br> kompiuteriu_priedai nerast- nerasta";
            }
            ?>

        </div>
    </div>

    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>

    <!-- Link to Bootstrap JS and jQuery files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>