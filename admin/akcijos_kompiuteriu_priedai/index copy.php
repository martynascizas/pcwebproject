<!DOCTYPE html>
<html lang="en">

<?php include '../components/head.php' ?>

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<body>
    <?php include '../components/header.php'; ?>
    <!-- KOMPIUTERIU PRIEDAI -->
    <div class="container marginTop">
        <div class="row justify-content-center">
            <div class="col-md-6 shadow p-3 mb-5 bg-body rounded">
                <h1 class="text-center">Kompiuterių Priedai - Akcijos - Įkelti naują</h1>
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="gamintojas" class="form-label">Gamintojas:</label>
                        <input type="text" class="form-control" id="gamintojas" name="gamintojas" required>
                    </div>
                    <div class="mb-3">
                        <label for="pavadinimas" class="form-label">Pavadinimas:</label>
                        <input type="text" class="form-control" id="pavadinimas" name="pavadinimas" required>
                    </div>
                    <div class="mb-3">
                        <label for="aprasymas" class="form-label">Aprasymas:</label>
                        <input type="text" class="form-control" id="aprasymas" name="aprasymas" required>
                    </div>
                    <div class="mb-3">
                        <label for="papildoma_informacija" class="form-label">Papildoma informacija:</label>
                        <input type="text" class="form-control" id="papildoma_informacija" name="papildoma_informacija" required>
                    </div>
                    <div class="mb-3">
                        <label for="kaina" class="form-label">Kaina:</label>
                        <input type="number" class="form-control" id="kaina" name="kaina" min="0.01" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="nauja_kaina" class="form-label">Nauja Kaina:</label>
                        <input type="number" class="form-control" id="nauja_kaina" name="nauja_kaina" min="0.01" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo:</label>
                        <input type="file" class="form-control" name="photo[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Įkelti</button>
                </form>
            </div>
        </div>

        <?php
        // Connect to the database
        require '../../db.php';

        // Check for errors
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if a akcijos_kompiuteriu_priedai was deleted
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            // Get the filenames of the photos for the monitor
            $sql = "SELECT `filename` FROM `akcijos_kompiuteriu_priedai_photos` WHERE `akcijos_kompiuteriu_priedai_id` = '$id'";
            $result = mysqli_query($conn, $sql);

            // Delete the akcijos_kompiuteriu_priedai and akcijos_kompiuteriu_priedai_photos from the database
            $sql = "DELETE FROM `akcijos_kompiuteriu_priedai` WHERE `id` = '$id'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM `akcijos_kompiuteriu_priedai_photos` WHERE `akcijos_kompiuteriu_priedai_id` = '$id'";
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

        // Retrieve akcijos_kompiuteriu_priedai data from the database
        // $sql = "SELECT * FROM `akcijos_kompiuteriu_priedai`";
        $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.papildoma_informacija, m.kaina, m.gamintojas, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM akcijos_kompiuteriu_priedai m 
    LEFT JOIN akcijos_kompiuteriu_priedai_photos mp ON m.id = mp.akcijos_kompiuteriu_priedai_id 
    GROUP BY m.id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display monitor info
                echo "<h3>" . $row["gamintojas"] . " "  . $row["pavadinimas"] . " " . $row["aprasymas"] . " " . $row["papildoma_informacija"] . " akcijos_kompiuteriu_priedai - " . $row["kaina"] . " EUR</h3>";

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
            echo "<br>Nieko nerasta";
        }
        // Close the database connection
        mysqli_close($conn);
        ?>


    </div>

</body>

</html>