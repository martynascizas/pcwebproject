<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>staliniai_kompiuteriai</title>
</head>

<body>
    <!-- NESIOJAMI KOMPIUTERIAI -->
    <div>
        <a href="../index.html">ATGAL</a>
        <br>
        <!-- crud staliniai_kompiuteriaiius -->
        <h1>Add Product To Staliniai Kompiuteriai</h1>
        <form action="insert.php" method="POST" enctype="multipart/form-data">
            <label for="gamintojas">Gamintojas:</label>
            <input type="text" id="gamintojas" name="gamintojas" required><br><br>

            <label for="procesorius">Procesorius:</label>
            <input type="text" id="procesorius" name="procesorius" required><br><br>

            <label for="vaizdo_plokste">vaizdo_plokste:</label>
            <input type="text" id="vaizdo_plokste" name="vaizdo_plokste" required><br><br>

            <label for="ram">ram:</label>
            <input type="text" id="ram" name="ram" required><br><br>

            <label for="hdd">hdd:</label>
            <input type="text" id="hdd" name="hdd" required><br><br>

            <label for="kaina">Kaina:</label>
            <input type="number" id="kaina" name="kaina" min="0.01" step="0.01" required><br><br>

            <label for="photo">Photo:</label>
            <input type="file" name="photo[]" multiple><br><br>

            <input type="submit" value="Add">
        </form>
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
                echo "<h3>" . $row["gamintojas"] . " " . "\" " . $row["procesorius"] . " " . $row["vaizdo_plokste"] . " " . $row["ram"]  . " " . $row["hdd"]  . " " . " staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h3>";

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
                // echo "<h5 class=\"card-title\">" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" staliniai_kompiuteriai - " . $row["kaina"] . " EUR</h5>";
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
            echo "<br> No staliniai_kompiuteriai found";
        }
        // Close the database connection
        mysqli_close($conn);
        ?>


    </div>
</body>

</html>