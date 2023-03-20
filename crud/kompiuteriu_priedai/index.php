<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>CMS</title>
</head>

<body>
    <!-- KOMPIUTERIU PRIEDAI -->
    <div>
        <a href="../index.html">ATGAL</a>
        <br>
        <?php
        // Connect to the database
        require '../../db.php';

        // Check for errors
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if a kompiuteriu_priedai was deleted
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            // Get the filenames of the photos for the monitor
            $sql = "SELECT `filename` FROM `kompiuteriu_priedai_photos` WHERE `kompiuteriu_priedai_id` = '$id'";
            $result = mysqli_query($conn, $sql);

            // Delete the kompiuteriu_priedai and kompiuteriu_priedai_photos from the database
            $sql = "DELETE FROM `kompiuteriu_priedai` WHERE `id` = '$id'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM `kompiuteriu_priedai_photos` WHERE `kompiuteriu_priedai_id` = '$id'";
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
                    echo "<img src='uploads/" . $photo . "' class='img-fluid' style='max-width: 30vw;'>";
                }
                echo "</div>";
                echo "<div class=\"col-md-8\">";
                echo "<div class=\"card-body\">";
                // echo "<h5 class=\"card-title\">" . $row["pavadinimas"] . " " . $row["aprasymas"] . "\" monitor - " . $row["kaina"] . " EUR</h5>";
                echo "<form method=\"post\" style=\"display: inline-block;\">";
                echo "<input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">";
                echo "<button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Delete</button>";
                echo "</form>";
                echo "<form action=\"edit.php\" method=\"get\" style=\"display: inline-block;\">";
                echo "<input type=\"hidden\" name=\"id\" value=\"{$row['id']}\">";
                echo "<button type=\"submit\" class=\"btn btn-primary\">Edit</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<hr>";
            }
        } else {
            echo "<br> No kompiuteriu priedai found";
        }
        // Close the database connection
        mysqli_close($conn);
        ?>

        <!-- crud monitorius -->
        <h1>Add Product To Kompiuteriu Priedai</h1>
        <form action="insert.php" method="POST" enctype="multipart/form-data">
            <label for="pavadinimas">pavadinimas:</label>
            <input type="text" id="pavadinimas" name="pavadinimas" required><br><br>

            <label for="aprasymas">Aprasymas:</label>
            <input type="text" id="aprasymas" name="aprasymas" required><br><br>

            <label for="kaina">Kaina:</label>
            <input type="number" id="kaina" name="kaina" min="0.01" step="0.01" required><br><br>

            <label for="photo">Photo:</label>
            <input type="file" name="photo[]" multiple><br><br>

            <input type="submit" value="Add">
        </form>
    </div>

</body>

</html>