<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to Bootstrap CSS file -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Svetaine</title>
</head>

<body>
    <a href="crud/index.html">CRUD</a>
    <br>
    <!-- coonnect to db -->
    <?php
    require 'db.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>

    <!-- MONITORIAI -->
    <hr>
    <div class="container">
        <h3 class="text-center mt-5">Monitoriai</h3>
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
                    echo '<h5 class="card-title">' . $row["gamintojas"] . ' ' . $row["ekrano_istrizaine"] . '" Monitorius - ' . $row["kaina"] . ' EUR</h5>';

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
                echo "<div class='col-12'>No monitors found</div>";
            }
            ?>
        </div>

        <!-- KOMPIUTERIU_PRIEDAI -->
        <hr>
        <h3 class="text-center mt-5">Kompiuterių priedai</h3>
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
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
                    echo '<h5 class="card-title">' . $row["pavadinimas"] . ': ' . $row["aprasymas"]  . ' - ' . $row["kaina"] . ' EUR</h5>';

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
                echo "<br> No kompiuteriu priedai found";
            }
            ?>

        </div>

        <!-- NESIOJAMI KOMPIUTERIAI -->
        <hr>
        <h3 class="text-center mt-5">Nešiojami Kompiuteriai</h3>
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM nesiojami_kompiuteriai m 
    LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id 
    GROUP BY m.id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    // Display monitor info
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-3 h-100 d-flex align-items-stretch">';
                    echo '<div class="card-body d-flex flex-column justify-content-between">';
                    echo "<h5>" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " nesiojami_kompiuteriai - " . $row["kaina"] . " EUR</h5>";

                    // Display photos
                    echo '<div class="d-flex align-items-center justify-content-center" style="height: 100%;">';
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
                echo "<br> No nesiojami_kompiuteriai found";
            }
            ?>
        </div>

        <!-- STALINIAI KOMPIUTERIAI -->
        <hr>
        <h3 class="text-center mt-5">Staliniai Kompiuteriai</h3>
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
                    echo "<h5>" . $row["gamintojas"] . " " . "\" " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h5>";

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
                echo "<br> No staliniai_kompiuteriai found";
            }
            ?>
        </div>
    </div>
    <!-- Close the database connection -->
    <?php
    mysqli_close($conn);
    ?>

    <!-- Link to Bootstrap JS and jQuery files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>