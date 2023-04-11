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
    $pavadinimas = $_POST["pavadinimas"];
    $aprasymas = $_POST["aprasymas"];
    $kaina = $_POST["kaina"];
    $gamintojas = $_POST["gamintojas"];

    // Update the kompiuteriu_priedai data
    $sql = "UPDATE kompiuteriu_priedai SET pavadinimas='$pavadinimas', gamintojas='$gamintojas', aprasymas='$aprasymas', kaina='$kaina' WHERE id='$id'";
    mysqli_query($conn, $sql);

    // Check if new photos were uploaded
    if (!empty($_FILES["photos"]["name"][0])) {
        // Remove old photos from the database
        $sql = "DELETE FROM kompiuteriu_priedai_photos WHERE kompiuteriu_priedai_id='$id'";
        mysqli_query($conn, $sql);

        // Upload new photos
        $files = $_FILES["photos"];
        $num_files = count($files["name"]);
        for ($i = 0; $i < $num_files; $i++) {
            $filename = $files["name"][$i];
            $tmp_name = $files["tmp_name"][$i];
            move_uploaded_file($tmp_name, "uploads/" . $filename);

            // Add the photo to the database
            $sql = "INSERT INTO kompiuteriu_priedai_photos (kompiuteriu_priedai_id, filename) VALUES ('$id', '$filename')";
            mysqli_query($conn, $sql);
        }
    }

    // Redirect back to the kompiuteriu_priedai list
    header("Location: index.php");
    exit();
}

// Get the kompiuteriu_priedai data
$id = $_GET["id"];
$sql = "SELECT * FROM kompiuteriu_priedai WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<h2>Edit Kompiuteriu Priedai</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Gamintojas:</label>
    <input type="text" name="gamintojas" value="<?php echo $row['gamintojas']; ?>"><br>
    <label>pavadinimas:</label>
    <input type="text" name="pavadinimas" value="<?php echo $row['pavadinimas']; ?>"><br>
    <label>Aprašymas:</label>
    <input type="text" name="aprasymas" value="<?php echo $row['aprasymas']; ?>"><br>
    <label>Kaina:</label>
    <input type="text" name="kaina" value="<?php echo $row['kaina']; ?>"><br>
    <label>Nuotraukos:</label>
    <input type="file" name="photos[]" multiple><br>
    <button type="submit" name="submit">Save Changes</button>
</form>
<?php
// Display the current photos
$sql = "SELECT * FROM kompiuteriu_priedai_photos WHERE kompiuteriu_priedai_id='$id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
}
?>