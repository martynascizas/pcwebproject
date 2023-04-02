<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once 'prodhead.php';
    ?>
</head>

<body>
    <!-- db conn -->
    <?php
    require '../db.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
   <form id="filter-form" method="POST">
    <div class="mb-3">
        <?php
        // Execute query to retrieve distinct gamintojas values
        $sql = "SELECT m.id, m.gamintojas, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
            FROM monitoriai m 
            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
            GROUP BY m.id";
        $result = mysqli_query($conn, $sql);
        ?>
        <label for="gamintojas" class="form-label">Gamintojas</label>
        <select class="form-select" id="gamintojas" name="gamintojas">
            <option value="">Visi</option>
            <?php
            // Loop through result set and generate options
            while ($row = mysqli_fetch_assoc($result)) {
                $selected = '';
                if ($_POST['gamintojas'] == $row['gamintojas']) {
                    $selected = 'selected';
                }
                echo '<option value="' . $row["gamintojas"] . '" ' . $selected . '>' . $row["gamintojas"] . '</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" name="filter_submit">Filtruoti</button>
</form>

<?php
// Check if form has been submitted
if (isset($_POST['filter_submit'])) {
    // Get the selected gamintojas value from the form
    $gamintojas = $_POST['gamintojas'];

    // Construct SQL query with the selected gamintojas value
    $sql = "SELECT * FROM monitoriai";
    if (!empty($gamintojas)) {
        $sql .= " WHERE gamintojas = '$gamintojas'";
    }

    // Execute query and fetch results
    $result = mysqli_query($conn, $sql);

    // Display results in HTML table
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Gamintojas</th><th>Ekrano išmatavimas</th><th>Kaina</th><th>Photo</th><th>Timestamp</th><th>Rezoliucija</th><th>Liečiamas ekranas</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["gamintojas"] . "</td><td>" . $row["ekrano_istrizaine"] . "</td><td>" . $row["kaina"] . "</td><td>" . $row["photo"] . "</td><td>" . $row["timestamp"] . "</td><td>" . $row["rezoliucija"] . "</td><td>" . $row["lieciamas_ekranas"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}
?>
    </div>

    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>

</body>

</html>