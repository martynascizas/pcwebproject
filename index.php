<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Project</title>
</head>

<body>
    <?php
    // Connect to the database
    require 'db.php';

    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if a monitoriai was deleted
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM `monitoriai` WHERE `id` = '$id'";
        mysqli_query($conn, $sql);
    }

    // Retrieve monitoriai data from the database
    // $sql = "SELECT * FROM `monitoriai`";
    $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM monitoriai m 
    LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
    GROUP BY m.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display monitor info
            echo "<h3>" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" monitor - " . $row["kaina"] . " EUR</h3>";

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
            // echo "<h5 class=\"card-title\">" . $row["gamintojas"] . " " . $row["ekrano_istrizaine"] . "\" monitor - " . $row["kaina"] . " EUR</h5>";
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
        echo "No monitors found.";
    }
    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- crud monitorius -->
    <h1>Add a new monitor</h1>
    <form action="insert.php" method="POST" enctype="multipart/form-data">
        <label for="gamintojas">Gamintojas:</label>
        <input type="text" id="gamintojas" name="gamintojas" required><br><br>

        <label for="ekrano_istrizaine">Ekrano išmatavimas (coliais):</label>
        <input type="number" id="ekrano_istrizaine" name="ekrano_istrizaine" min="1" max="100" required><br><br>

        <label for="kaina">Kaina:</label>
        <input type="number" id="kaina" name="kaina" min="0.01" step="0.01" required><br><br>

        <label for="photo">Photo:</label>
        <input type="file" name="photo[]" multiple><br><br>

        <input type="submit" value="Add monitor">
    </form>
</body>

</html>