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
        $pavadinimas = mysqli_real_escape_string($conn, $_POST['pavadinimas']);
        $aprasymas = mysqli_real_escape_string($conn, $_POST['aprasymas']);
        $papildoma_informacija = mysqli_real_escape_string($conn, $_POST['papildoma_informacija']);
        $kaina = mysqli_real_escape_string($conn, $_POST['kaina']);
        $nauja_kaina = mysqli_real_escape_string($conn, $_POST['nauja_kaina']);

        // Update the akcijos_kompiuteriu_priedai data
        $sql = "UPDATE akcijos_kompiuteriu_priedai SET gamintojas='$gamintojas', pavadinimas='$pavadinimas', kaina='$kaina', aprasymas='$aprasymas', papildoma_informacija='$papildoma_informacija', nauja_kaina='$nauja_kaina' WHERE id='$id'";
        mysqli_query($conn, $sql);

        // Check if new photos were uploaded
        if (!empty($_FILES["photos"]["name"][0])) {
            // Remove old photos from the database
            $sql = "DELETE FROM akcijos_kompiuteriu_priedai_photos WHERE akcijos_kompiuteriu_priedai_id='$id'";
            mysqli_query($conn, $sql);

            // Upload new photos
            $files = $_FILES["photos"];
            $num_files = count($files["name"]);
            for ($i = 0; $i < $num_files; $i++) {
                $filename = $files["name"][$i];
                $tmp_name = $files["tmp_name"][$i];
                move_uploaded_file($tmp_name, "uploads/" . $filename);

                // Add the photo to the database
                $sql = "INSERT INTO akcijos_kompiuteriu_priedai_photos (akcijos_kompiuteriu_priedai_id, filename) VALUES ('$id', '$filename')";
                mysqli_query($conn, $sql);
            }
        }

        // Redirect back to the akcijos_kompiuteriu_priedai list
        header("Location: index.php");
        exit();
    }

    // Get the akcijos_kompiuteriu_priedai data
    $id = $_GET["id"];
    $sql = "SELECT * FROM akcijos_kompiuteriu_priedai WHERE id='$id'";
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
                            <label for="pavadinimas" class="form-label">Pavadinimas:</label>
                            <input type="text" class="form-control" id="pavadinimas" name="pavadinimas" value="<?php echo $row['pavadinimas']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="aprasymas" class="form-label">Aprasymas:</label>
                            <input type="text" class="form-control" id="aprasymas" name="aprasymas" value="<?php echo $row['aprasymas']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="papildoma_informacija" class="form-label">Papildoma informacija:</label>
                            <input type="text" class="form-control" id="papildoma_informacija" name="papildoma_informacija" value="<?php echo $row['papildoma_informacija']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kaina" class="form-label">Kaina:</label>
                            <input type="number" class="form-control" id="kaina" name="kaina" value="<?php echo $row['kaina']; ?>" min="0.01" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="nauja_kaina" class="form-label">Nauja kaina:</label>
                            <input type="number" class="form-control" id="nauja_kaina" name="nauja_kaina"
                                value="<?php echo $row['nauja_kaina']; ?>" min="0.01" step="0.01" required>
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
        $sql = "SELECT * FROM akcijos_kompiuteriu_priedai_photos WHERE akcijos_kompiuteriu_priedai_id='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
        }
        ?>
    </div>
</body>

</html>