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
    $ram = mysqli_real_escape_string($conn, $_POST['ram']);
    $hdd = mysqli_real_escape_string($conn, $_POST['hdd']);
    $kaina = mysqli_real_escape_string($conn, $_POST['kaina']);

    // Update the monitoriai data
    $sql = "UPDATE staliniai_kompiuteriai SET gamintojas='$gamintojas', kaina='$kaina', procesorius='$procesorius', vaizdo_plokste='$vaizdo_plokste', ram='$ram', hdd='$hdd' WHERE id='$id'";
    mysqli_query($conn, $sql);

    // Check if new photos were uploaded
    if (!empty($_FILES["photos"]["name"][0])) {
        // Remove old photos from the database
        $sql = "DELETE FROM staliniai_kompiuteriai_photos WHERE staliniai_kompiuteriai_id='$id'";
        mysqli_query($conn, $sql);

        // Upload new photos
        $files = $_FILES["photos"];
        $num_files = count($files["name"]);
        for ($i = 0; $i < $num_files; $i++) {
            $filename = $files["name"][$i];
            $tmp_name = $files["tmp_name"][$i];
            move_uploaded_file($tmp_name, "uploads/" . $filename);

            // Add the photo to the database
            $sql = "INSERT INTO staliniai_kompiuteriai_photos (staliniai_kompiuteriai_id, filename) VALUES ('$id', '$filename')";
            mysqli_query($conn, $sql);
        }
    }

    // Redirect back to the staliniai_kompiuteriai list
    header("Location: index.php");
    exit();
}

// Get the staliniai_kompiuteriai data
$id = $_GET["id"];
$sql = "SELECT * FROM staliniai_kompiuteriai WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<h2>Edit Monitor</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label for="gamintojas">Gamintojas:</label>
    <input type="text" id="gamintojas" name="gamintojas" value="<?php echo $row['gamintojas']; ?>" required><br><br>

    <label for="procesorius">Procesorius:</label>
    <input type="text" id="procesorius" name="procesorius" value="<?php echo $row['procesorius']; ?>" required><br><br>

    <label for="vaizdo_plokste">vaizdo_plokste:</label>
    <input type="text" id="vaizdo_plokste" name="vaizdo_plokste" value="<?php echo $row['vaizdo_plokste']; ?>" required><br><br>

    <label for="ram">ram:</label>
    <input type="text" id="ram" name="ram" value="<?php echo $row['ram']; ?>" required><br><br>

    <label for="hdd">hdd:</label>
    <input type="text" id="hdd" name="hdd" value="<?php echo $row['hdd']; ?>" required><br><br>

    <label for="kaina">Kaina:</label>
    <input type="number" id="kaina" name="kaina" value="<?php echo $row['kaina']; ?>" min="0.01" step="0.01" required><br><br>

    <label for="photo">Photo:</label>
    <input type="file" name="photo[]" multiple><br><br>

    <button type="submit" name="submit">Save Changes</button>
</form>
<?php
// Display the current photos
$sql = "SELECT * FROM staliniai_kompiuteriai_photos WHERE staliniai_kompiuteriai_id='$id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
}
?>