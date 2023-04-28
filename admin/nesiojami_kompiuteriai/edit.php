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
    <?php
    // Connect to the database
    require '../../db.php';

    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the form has been submitted
    if (isset($_POST["submit"])) {
        // Get the form data
        $id = $_POST["id"];
        $gamintojas = mysqli_real_escape_string($conn, $_POST['gamintojas']);
        $procesorius = mysqli_real_escape_string($conn, $_POST['procesorius']);
        $vaizdo_plokste = mysqli_real_escape_string($conn, $_POST['vaizdo_plokste']);
        $ekrano_istrizaine = mysqli_real_escape_string($conn, $_POST['ekrano_istrizaine']);
        $ram = mysqli_real_escape_string($conn, $_POST['ram']);
        $hdd = mysqli_real_escape_string($conn, $_POST['hdd']);
        $kaina = mysqli_real_escape_string($conn, $_POST['kaina']);

        // Update the monitoriai data
        $sql = "UPDATE nesiojami_kompiuteriai SET gamintojas='$gamintojas', ekrano_istrizaine='$ekrano_istrizaine', kaina='$kaina', procesorius='$procesorius', vaizdo_plokste='$vaizdo_plokste', ram='$ram', hdd='$hdd' WHERE id='$id'";
        mysqli_query($conn, $sql);

        // Check if new photos were uploaded
        if (!empty($_FILES["photos"]["name"][0])) {
            // Remove old photos from the database
            $sql = "DELETE FROM nesiojami_kompiuteriai_photos WHERE nesiojami_kompiuteriai_id='$id'";
            mysqli_query($conn, $sql);

            // Upload new photos
            $files = $_FILES["photos"];
            $num_files = count($files["name"]);
            for ($i = 0; $i < $num_files; $i++) {
                $filename = $files["name"][$i];
                $tmp_name = $files["tmp_name"][$i];
                move_uploaded_file($tmp_name, "uploads/" . $filename);

                // Add the photo to the database
                $sql = "INSERT INTO nesiojami_kompiuteriai_photos (nesiojami_kompiuteriai_id, filename) VALUES ('$id', '$filename')";
                mysqli_query($conn, $sql);
            }
        }

        // Redirect back to the nesiojami_kompiuteriai list
        header("Location: index.php");
        exit();
    }

    // Get the nesiojami_kompiuteriai data
    $id = $_GET["id"];
    $sql = "SELECT * FROM nesiojami_kompiuteriai WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <div>
        <div class="container marginTop">
            <div class="row justify-content-center">
                <div class="col-md-6 shadow p-3 mb-5 bg-body rounded">
                    <h2>Redaguoti</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3">
                            <label for="gamintojas" class="form-label">Gamintojas:</label>
                            <input type="text" class="form-control" id="gamintojas" name="gamintojas" value="<?php echo $row['gamintojas']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ekrano_istrizaine" class="form-label">ekrano istrizaine:</label>
                            <input type="text" class="form-control" id="ekrano_istrizaine" name="ekrano_istrizaine" value="<?php echo $row['ekrano_istrizaine']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="procesorius" class="form-label">Procesorius:</label>
                            <input type="text" class="form-control" id="procesorius" name="procesorius" value="<?php echo $row['procesorius']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="vaizdo_plokste" class="form-label">Vaizdo plokštė:</label>
                            <input type="text" class="form-control" id="vaizdo_plokste" name="vaizdo_plokste" value="<?php echo $row['vaizdo_plokste']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM:</label>
                            <input type="text" class="form-control" id="ram" name="ram" value="<?php echo $row['ram']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hdd" class="form-label">HDD:</label>
                            <input type="text" class="form-control" id="hdd" name="hdd" value="<?php echo $row['hdd']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kaina" class="form-label">Kaina:</label>
                            <input type="number" class="form-control" id="kaina" name="kaina" value="<?php echo $row['kaina']; ?>" min="0.01" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="photos" class="form-label">Photo:</label>
                            <input type="file" class="form-control" name="photos[]" multiple>
                        </div>
                        <button type="submit" name="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        // Display the current photos
        $sql = "SELECT * FROM nesiojami_kompiuteriai_photos WHERE nesiojami_kompiuteriai_id='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
        }
        ?>
    </div>
</body>

</html>