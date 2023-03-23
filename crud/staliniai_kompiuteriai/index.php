<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to Bootstrap CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>staliniai_kompiuteriai</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    <!-- NESIOJAMI KOMPIUTERIAI -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 shadow p-3 mb-5 bg-body rounded">
                <h1 class="text-center">Staliniai Kompiuteriai - Įelti naują</h1>
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="gamintojas" class="form-label">Gamintojas:</label>
                        <input type="text" class="form-control" id="gamintojas" name="gamintojas" required>
                    </div>
                    <div class="mb-3">
                        <label for="procesorius" class="form-label">Procesorius:</label>
                        <input type="text" class="form-control" id="procesorius" name="procesorius" required>
                    </div>
                    <div class="mb-3">
                        <label for="vaizdo_plokste" class="form-label">Vaizdo plokštė:</label>
                        <input type="text" class="form-control" id="vaizdo_plokste" name="vaizdo_plokste" required>
                    </div>
                    <div class="mb-3">
                        <label for="ram" class="form-label">RAM:</label>
                        <input type="text" class="form-control" id="ram" name="ram" required>
                    </div>
                    <div class="mb-3">
                        <label for="hdd" class="form-label">HDD:</label>
                        <input type="text" class="form-control" id="hdd" name="hdd" required>
                    </div>
                    <div class="mb-3">
                        <label for="kaina" class="form-label">Kaina:</label>
                        <input type="number" class="form-control" id="kaina" name="kaina" min="0.01" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Nuotraukos:</label>
                        <input type="file" class="form-control" name="photo[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Įkelti</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    // Connect to the database
    require '../../db.php';

    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if a staliniai_kompiuteriai was deleted
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        // Get the filenames of the photos for the staliniai_kompiuteriai
        $sql = "SELECT `filename` FROM `staliniai_kompiuteriai_photos` WHERE `staliniai_kompiuteriai_id` = '$id'";
        $result = mysqli_query($conn, $sql);

        // Delete the staliniai_kompiuteriai and staliniai_kompiuteriai_photos from the database
        $sql = "DELETE FROM `staliniai_kompiuteriai` WHERE `id` = '$id'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM `staliniai_kompiuteriai_photos` WHERE `staliniai_kompiuteriai_id` = '$id'";
        mysqli_query($conn, $sql);

        // Delete the photo files from the server
        while ($row = mysqli_fetch_assoc($result)) {
            $filename = $row['filename'];
            $filepath = "uploads/" . $filename;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }
    }

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
            echo "<h3>" . $row["gamintojas"] . " " . " " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h3>";

            // Display photos
            $photos = explode(",", $row["photos"]);
            echo "<div class=\"card mb-3\">";
            echo "<div class=\"row g-0\">";
            echo "<div class=\"col-md-4 text-center\">";
            foreach ($photos as $photo) {
                echo "<img src='uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
            }
            echo "</div>";
            echo "<div class=\"col-md-8\">";
            echo "<div class=\"card-body\">";
            echo "<form method=\"post\" style=\"display: inline-block;\">";
            echo "<input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">";
            echo "<button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Pašalinti</button>";
            echo "</form>";
            echo "<form action=\"edit.php\" method=\"get\" style=\"display: inline-block;\">";
            echo "<input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">";
            echo "<button type=\"submit\" class=\"btn btn-primary\">Redaguoti</button>";
            echo "</form>";
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


    </div>
</body>

</html>