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

    <div class="d-flex align-items-center justify-content-center vh-100" style="background-image: url('assets/img/background.jpg'); background-size: cover; background-position: center;">
        <div class="text-center text-white">
            <h1>Lorem Ipsum</h1>
            <p>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, <br> consectetur, adipisci velit..."
                "There is no one who loves pain itself,<br> who seeks after it and wants to have it, <br> simply because it is pain..."</p>
        </div>
    </div>

    <div class="container products_section mb-5">
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
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 shadow-sm">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                    echo '<p class="card-text">Ekrano Įstrižainė: ' . $row["ekrano_istrizaine"] . '"</p>';
                    echo '<p class="card-text">Procesorius: ' . $row["procesorius"] . '</p>';
                    echo '<p class="card-text">Vaizdo Plokštė: ' . $row["vaizdo_plokste"] . '</p>';
                    echo '<p class="card-text">Atmintis (RAM): ' . $row["ram"] . '</p>';
                    echo '<p class="card-text">Kietasis diskas (HDD): ' . $row["hdd"] . '</p>';
                    echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    $photos = explode(",", $row["photos"]);
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    foreach ($photos as $photo) {
                        echo '<img src="crud/nesiojami_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p class='text-muted'>nesiojami_kompiuteriai - nerasta</p>";
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
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 shadow-sm">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                    echo '<p class="card-text">Procesorius: ' . $row["procesorius"] . '</p>';
                    echo '<p class="card-text">Vaizdo Plokštė: ' . $row["vaizdo_plokste"] . '</p>';
                    echo '<p class="card-text">Atmintis (RAM): ' . $row["ram"] . '</p>';
                    echo '<p class="card-text">Kietasis diskas (HDD): ' . $row["hdd"] . '</p>';
                    echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                    echo '<div class="d-flex align-items-center justify-content-center">';
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
                echo "<p class='text-muted'>staliniai_kompiuteriai - nerasta</p>";
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
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 shadow-sm">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                    echo '<p class="card-text">Ekrano Įstrižainė: ' . $row["ekrano_istrizaine"] . '"' . '</p>';
                    echo '<p class="card-text">Prekių Kategorija: ' . 'Monitoriai' . '</p>';
                    echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                    echo '<div class="d-flex align-items-center justify-content-center">';
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
                echo "<p class='text-muted'>monitoriai - nerasta</p>";
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
         



                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 shadow-sm">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                    echo '<p class="card-text">Pavadinimas: ' . $row["pavadinimas"] . '' . '</p>';
                    echo '<p class="card-text">Aprašymas: ' .  $row["aprasymas"] . '</p>';
                    echo  "Prekių Kategorija: " . " Kompiuterių priedai " . " </p>";
                    echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                    echo '<div class="d-flex align-items-center justify-content-center">';
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
                echo "<p class='text-muted'>Kompiuterių priedai - nerasta</p>";
            }
            ?>

        </div>
    </div>
    <!-- footer -->
    <?php
    require_once 'components/footer.php';
    ?>

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