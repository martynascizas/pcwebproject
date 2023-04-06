<select class="form-select" id="gamintojas" name="gamintojas">
    <option value="">Visi</option>
    <?php
    $sql = "SELECT gamintojas, COUNT(*) as count FROM monitoriai GROUP BY gamintojas";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($_POST['gamintojas'] == $row['gamintojas']) ? 'selected' : '';
        echo '<option value="' . $row["gamintojas"] . '" ' . $selected . '>' . $row["gamintojas"] . ' (' . $row["count"] . ')</option>';
    }
    ?>
</select>


<select class="form-select" id="gamintojas" name="gamintojas">
    <option value="">Visi</option>
    <?php
    // Execute query and fetch results
    $sql = "SELECT gamintojas, COUNT(*) AS total FROM monitoriai GROUP BY gamintojas ORDER BY gamintojas ASC";
    $result = mysqli_query($conn, $sql);

    // Loop through result set and generate options
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = '';
        if ($_POST['gamintojas'] == $row['gamintojas']) {
            $selected = 'selected';
        }
        echo '<option value="' . $row["gamintojas"] . '" ' . $selected . '>' . $row["gamintojas"] . ' (' . $row["total"] . ')</option>';
    }
    ?>
</select>