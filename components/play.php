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