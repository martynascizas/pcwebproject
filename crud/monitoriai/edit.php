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
    $gamintojas = $_POST["gamintojas"];
    $ekrano_istrizaine = $_POST["ekrano_istrizaine"];
    $lieciamas_ekranas = mysqli_real_escape_string($conn, $_POST['touchscreen']);
    $rezoliucija = mysqli_real_escape_string($conn, $_POST['rezoliucija']);
    $kaina = $_POST["kaina"];

    // Update the monitoriai data
    $sql = "UPDATE monitoriai SET gamintojas='$gamintojas', ekrano_istrizaine='$ekrano_istrizaine', lieciamas_ekranas='$lieciamas_ekranas', rezoliucija = '$rezoliucija', kaina='$kaina' WHERE id='$id'";
    mysqli_query($conn, $sql);

    // Check if new photos were uploaded
    if (!empty($_FILES["photos"]["name"][0])) {
        // Remove old photos from the database
        $sql = "DELETE FROM monitoriai_photos WHERE monitoriai_id='$id'";
        mysqli_query($conn, $sql);

        // Upload new photos
        $files = $_FILES["photos"];
        $num_files = count($files["name"]);
        for ($i = 0; $i < $num_files; $i++) {
            $filename = $files["name"][$i];
            $tmp_name = $files["tmp_name"][$i];
            move_uploaded_file($tmp_name, "uploads/" . $filename);

            // Add the photo to the database
            $sql = "INSERT INTO monitoriai_photos (monitoriai_id, filename) VALUES ('$id', '$filename')";
            mysqli_query($conn, $sql);
        }
    }

    // Redirect back to the monitoriai list
    header("Location: index.php");
    exit();
}

// Get the monitoriai data
$id = $_GET["id"];
$sql = "SELECT * FROM monitoriai WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<h2>Edit monitoriai</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Gamintojas:</label>
    <input type="text" name="gamintojas" value="<?php echo $row['gamintojas']; ?>"><br>
    <label>Ekrano išmatavimai:</label>
    <input type="text" name="ekrano_istrizaine" value="<?php echo $row['ekrano_istrizaine']; ?>"><br>
    <label for="touchscreen">Liečiamas ekranas:</label>
    <select id="touchscreen" name="touchscreen">
        <option value="yes" <?php if ($row['lieciamas_ekranas'] == 'yes') echo ' selected'; ?>>taip</option>
        <option value="no" <?php if ($row['lieciamas_ekranas'] == 'no') echo ' selected'; ?>>ne</option>
    </select><br>
    <div class="mb-3">
        <label for="rezoliucija" class="form-label">Rezoliucija:</label>
        <input type="text" class="form-control" id="rezoliucija" name="rezoliucija" value="<?php echo $row['rezoliucija']; ?>">
    </div>
    <label>Kaina:</label>
    <input type="text" name="kaina" value="<?php echo $row['kaina']; ?>"><br>
    <label>Nuotraukos:</label>
    <input type="file" name="photos[]" multiple><br>
    <button type="submit" name="submit">Save Changes</button>
</form>
<?php
// Display the current photos
$sql = "SELECT * FROM monitoriai_photos WHERE monitoriai_id='$id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
}
?>