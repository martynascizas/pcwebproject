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
    <!-- navbar -->
    <?php
    require_once 'prodnav.php';
    ?>

    <div class="wrapper">
        <div class="container products_section mb-5 products-margin">
            <h3 id="monitoriai" class="text-center mb-5">Monitoriai</h3>
            <form id="filter-form" method="POST">
                <div class="mb-3">
                    <?php
                    // Construct SQL query with the selected gamintojas value
                    $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.rezoliucija, m.lieciamas_ekranas, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') 
            AS photos
            FROM monitoriai m 
            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id";

                    if (!empty($gamintojas) && empty($ekrano_istrizaine)) {
                        $sql .= " WHERE gamintojas = '$gamintojas' GROUP BY m.id";
                    } else if (empty($gamintojas) && !empty($ekrano_istrizaine)) {
                        $sql .= " WHERE ekrano_istrizaine = '$ekrano_istrizaine' GROUP BY m.id";
                    } else if (!empty($gamintojas) && !empty($ekrano_istrizaine)) {
                        $sql .= " WHERE gamintojas = '$gamintojas' AND ekrano_istrizaine = '$ekrano_istrizaine' GROUP BY m.id";
                    } else {
                        $sql .= " GROUP BY m.id";
                    }

                    // Execute query and fetch results
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <label for="gamintojas" class="form-label">Gamintojas</label>
                    <select class="form-select" id="gamintojas" name="gamintojas">
                        <option value="">Visi</option>
                        <?php
                        // Reset the pointer of the result set to the beginning
                        mysqli_data_seek($result, 0);

                        // Loop through result set and generate options
                        $selected_values = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = '';
                            if ($_POST['gamintojas'] == $row['gamintojas']) {
                                $selected = 'selected';
                            }
                            if (!in_array($row['gamintojas'], $selected_values)) {
                                echo '<option value="' . $row["gamintojas"] . '" ' . $selected . '>' . $row["gamintojas"] . '</option>';
                                $selected_values[] = $row['gamintojas'];
                            }
                        }
                        ?>
                    </select>

                    <label for="ekrano_istrizaine" class="form-label">Ekrano įstrižainė</label>
                    <select class="form-select" id="ekrano_istrizaine" name="ekrano_istrizaine">
                        <option value="">Visi</option>
                        <?php
                        // Reset the pointer of the result set to the beginning
                        mysqli_data_seek($result, 0);

                        // Loop through result set and generate options
                        $selected_values = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = '';
                            if ($_POST['ekrano_istrizaine'] == $row['ekrano_istrizaine']) {
                                $selected = 'selected';
                            }
                            if (!in_array($row['ekrano_istrizaine'], $selected_values)) {
                                echo '<option value="' . $row["ekrano_istrizaine"] . '" ' . $selected . '>' . $row["ekrano_istrizaine"] . '</option>';
                                $selected_values[] = $row['ekrano_istrizaine'];
                            }
                        }

                        ?>
                    </select>

                </div>
                <button type="submit" class="btn btn-primary" name="filter_submit">Filtruoti</button>
            </form>

            <!-- <?php
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
                    ?> -->
        <?php
                        // Check if form has been submitted
                        if (isset($_POST['filter_submit'])) {
                            // Get the selected gamintojas and ekrano_istrizaine values from the form
                            $gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];

                            // Construct SQL query with the selected gamintojas and ekrano_istrizaine values
                            $sql =
                                "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.rezoliucija, m.lieciamas_ekranas, m.kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') 
                            AS photos
                            FROM monitoriai m 
                            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id";
                            if (!empty($gamintojas) && empty($ekrano_istrizaine)) {
                                $sql .= " WHERE gamintojas = '$gamintojas' GROUP BY m.id";
                            } else if (empty($gamintojas) && !empty($ekrano_istrizaine)) {
                                $sql .= " WHERE ekrano_istrizaine = '$ekrano_istrizaine' GROUP BY m.id";
                            } else if (!empty($gamintojas) && !empty($ekrano_istrizaine)) {
                                $sql .= " WHERE gamintojas = '$gamintojas' AND ekrano_istrizaine = '$ekrano_istrizaine' GROUP BY m.id";
                            } else {
                                $sql .= " GROUP BY m.id";
                            }
                            // Execute query and fetch results
                            $result = mysqli_query($conn, $sql);
                            // Display results in HTML table
                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="col">';
                                    echo '<div class="card h-100">';
                                    echo '<img src="../crud/monitoriai/uploads/' . $row["photos"] . '" class="card-img-top" alt="Product Image">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                                    echo '<p class="card-text">' . $row["kaina"] . '</p>';
                                    echo '<p class="card-text">' . $row["ekrano_istrizaine"] . '</p>';
                                    echo '<p class="card-text">' . $row["rezoliucija"] . '</p>';
                                    echo '<p class="card-text">' . $row["lieciamas_ekranas"] . '</p>';
                                    echo '</div>';
                                    echo '<div class="card-footer">';
                                    echo '<small class="text-muted">' . $row["timestamp"] . '</small>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            } else {
                                echo "0 results";
                            }
                        }
                    }
        ?>
        </div>
        <!-- footer -->
        <?php
        require_once 'footer.php';
        ?>
    </div>
    </div>
    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>
</body>

</html>