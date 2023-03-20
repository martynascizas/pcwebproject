<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Svetaine</title>
</head>

<body>
    <a href="crud/index.html">CRUD</a>
    <br>
    <?php
    // Connect to the database
    require 'db.php';

    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // MONITORIAI
    // Retrieve monitoriai data from the database
    // $sql = "SELECT * FROM `monitoriai`";
    $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM monitoriai m 
    LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
    GROUP BY m.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display monitor info
            echo "<h3>" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" monitor - " . $row["kaina"] . " EUR</h3>";

            // Display photos
            $photos = explode(",", $row["photos"]);
            echo "<div class=\"card mb-3\">";
            echo "<div class=\"row g-0\">";
            echo "<div class=\"col-md-4 text-center\">";
            foreach ($photos as $photo) {
                echo "<img src='crud/monitoriai/uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
            }
            echo "</div>";
            echo "<div class=\"col-md-8\">";
            echo "<div class=\"card-body\">";
            // echo "<h5 class=\"card-title\">" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" monitor - " . $row["kaina"] . " EUR</h5>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "<br> No monitors found";
    }

    // KOMPIUTERIU PRIEDAI
    // Retrieve kompiuteriu_priedai data from the database
    // $sql = "SELECT * FROM `kompiuteriu_priedai`";
    $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM kompiuteriu_priedai m 
    LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id 
    GROUP BY m.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display monitor info
            echo "<h3>" . $row["pavadinimas"] . " " . $row["aprasymas"] . "\" kompiuteriu_priedai - " . $row["kaina"] . " EUR</h3>";

            // Display photos
            $photos = explode(",", $row["photos"]);
            echo "<div class=\"card mb-3\">";
            echo "<div class=\"row g-0\">";
            echo "<div class=\"col-md-4 text-center\">";
            foreach ($photos as $photo) {
                echo "<img src='crud/kompiuteriu_priedai/uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
            }
            echo "</div>";
            echo "<div class=\"col-md-8\">";
            echo "<div class=\"card-body\">";
            // echo "<h5 class=\"card-title\">" . $row["pavadinimas"] . " " . $row["aprasymas"] . "\" monitor - " . $row["kaina"] . " EUR</h5>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "<br> No kompiuteriu priedai found";
    }

    // NESIOJAMI KOMPIUTERIAI
    $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM nesiojami_kompiuteriai m 
    LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id 
    GROUP BY m.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display nesiojami_kompiuteriai info
            echo "<h3>" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " nesiojami_kompiuteriai - " . $row["kaina"] . " EUR</h3>";

            // Display photos
            $photos = explode(",", $row["photos"]);
            echo "<div class=\"card mb-3\">";
            echo "<div class=\"row g-0\">";
            echo "<div class=\"col-md-4 text-center\">";
            foreach ($photos as $photo) {
                echo "<img src='crud/nesiojami_kompiuteriai/uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
            }
            echo "</div>";
            echo "<div class=\"col-md-8\">";
            echo "<div class=\"card-body\">";
            // echo "<h5 class=\"card-title\">" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" nesiojami_kompiuteriai - " . $row["kaina"] . " EUR</h5>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "<br> No nesiojami_kompiuteriai found";
    }

    // STALINIAI KOMPIUTERIAI
    // Retrieve staliniai_kompiuteriai data from the database
    // $sql = "SELECT * FROM `staliniai_kompiuteriai`";
    $sql = "SELECT m.id, m.gamintojas, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM staliniai_kompiuteriai m 
    LEFT JOIN staliniai_kompiuteriai_photos mp ON m.id = mp.staliniai_kompiuteriai_id 
    GROUP BY m.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display staliniai_kompiuteriai info
            echo "<h3>" . $row["gamintojas"] . " " . "\" " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h3>";

            // Display photos
            $photos = explode(",", $row["photos"]);
            echo "<div class=\"card mb-3\">";
            echo "<div class=\"row g-0\">";
            echo "<div class=\"col-md-4 text-center\">";
            foreach ($photos as $photo) {
                echo "<img src='crud/staliniai_kompiuteriai/uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
            }
            echo "</div>";
            echo "<div class=\"col-md-8\">";
            echo "<div class=\"card-body\">";
            // echo "<h5 class=\"card-title\">" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h5>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "<br> No staliniai_kompiuteriai found";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>