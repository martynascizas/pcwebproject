<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to Bootstrap CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <title>kompiuteriu_priedai</title>
</head>

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
        $kaina = mysqli_real_escape_string($conn, $_POST['kaina']);

        // Update the kompiuteriu_priedai data
        $sql = "UPDATE kompiuteriu_priedai SET gamintojas='$gamintojas', pavadinimas='$pavadinimas', kaina='$kaina', aprasymas='$aprasymas' WHERE id='$id'";
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
    <div>
        <div class="container">
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
        $sql = "SELECT * FROM kompiuteriu_priedai_photos WHERE kompiuteriu_priedai_id='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img src='uploads/" . $row["filename"] . "' width='200'>";
        }
        ?>
    </div>
</body>

</html>