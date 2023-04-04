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

                    if (!empty($gamintojas) || !empty($ekrano_istrizaine) || !empty($rezoliucija) || !empty($lieciamas_ekranas) || !empty($kaina)) {
                        $sql .= " WHERE ";

                        if (!empty($gamintojas)) {
                            $sql .= "gamintojas = '$gamintojas' AND ";
                        }

                        if (!empty($ekrano_istrizaine)) {
                            $sql .= "ekrano_istrizaine = '$ekrano_istrizaine' AND ";
                        }

                        if (!empty($rezoliucija)) {
                            $sql .= "rezoliucija = '$rezoliucija' AND ";
                        }

                        if (!empty($lieciamas_ekranas)) {
                            $sql .= "lieciamas_ekranas = '$lieciamas_ekranas' AND ";
                        }

                        if (!empty($kaina)) {
                            $sql .= "kaina <= '$kaina' AND ";
                        }

                        $sql = rtrim($sql, "AND ");
                    }

                    $sql .= " GROUP BY m.id";

                    // Execute query and fetch results
                    $result = mysqli_query($conn, $sql);

                    // Generate select options for gamintojas
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

                    <label for="rezoliucija" class="form-label">Rezoliucija</label>
                    <select class="form-select" id="rezoliucija" name="rezoliucija">
                        <option value="">Visi</option>
                        <?php
                        // Reset the pointer of the result set to the beginning
                        mysqli_data_seek($result, 0);

                        // Loop through result set and generate options
                        $selected_values = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = '';
                            if ($_POST['rezoliucija'] == $row['rezoliucija']) {
                                $selected = 'selected';
                            }
                            if (!in_array($row['rezoliucija'], $selected_values)) {
                                echo '<option value="' . $row["rezoliucija"] . '" ' . $selected . '>' . $row["rezoliucija"] . '</option>';
                                $selected_values[] = $row['rezoliucija'];
                            }
                        }
                        ?>
                    </select>

                    <label for="lieciamas_ekranas" class="form-label">Lieciamas ekranas</label>
                    <select class="form-select" id="lieciamas_ekranas" name="lieciamas_ekranas">
                        <option value="">Visi</option>
                        <?php
                        // Reset the pointer of the result set to the beginning
                        mysqli_data_seek($result, 0);

                        // Loop through result set and generate options
                        $selected_values = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = '';
                            if ($_POST['lieciamas_ekranas'] == $row['lieciamas_ekranas']) {
                                $selected = 'selected';
                            }
                            if (!in_array($row['lieciamas_ekranas'], $selected_values)) {
                                echo '<option value="' . $row["lieciamas_ekranas"] . '" ' . $selected . '>' . $row["lieciamas_ekranas"] . '</option>';
                                $selected_values[] = $row['lieciamas_ekranas'];
                            }
                        }
                        ?>
                    </select>

                    <label for="kaina" class="form-label">Kaina iki (€)</label>
                    <input type="number" class="form-control" id="kaina" name="kaina" min="0" max="9999" step="30" value="<?php echo isset($_POST['kaina']) ? $_POST['kaina'] : ''; ?>">

                </div>
                <button type="submit" class="btn btn-primary" name="filter_submit">Filtruoti</button>
            </form>


            <?php
            // Check if form has been submitted
            if (isset($_POST['filter_submit'])) {
                // Get the selected gamintojas and ekrano_istrizaine values from the form
                $gamintojas = $_POST['gamintojas'];
                $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                $rezoliucija = $_POST['rezoliucija'];
                $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                $kaina = $_POST['kaina'];

                $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.rezoliucija, m.lieciamas_ekranas, m.kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos
                FROM monitoriai m 
                LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id";

                // Loop all possible conditions
                $where_conditions = [];

                if (!empty($gamintojas)) {
                    $where_conditions[] = "gamintojas = '$gamintojas'";
                }

                if (!empty($ekrano_istrizaine)) {
                    $where_conditions[] = "ekrano_istrizaine = '$ekrano_istrizaine'";
                }

                if (!empty($rezoliucija)) {
                    $where_conditions[] = "rezoliucija = '$rezoliucija'";
                }

                if (!empty($lieciamas_ekranas)) {
                    $where_conditions[] = "lieciamas_ekranas = '$lieciamas_ekranas'";
                }

                if (!empty($kaina)) {
                    $where_conditions[] = "kaina <= $kaina";
                }

                if (!empty($where_conditions)) {
                    $sql .= " WHERE " . implode(" AND ", $where_conditions);
                }

                $sql .= " GROUP BY m.id";

                // Execute query and fetch results
                $result = mysqli_query($conn, $sql);
                // Display results in HTML table
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col">';
                        echo '<div class="card h-100" style="display: flex; flex-direction: column; height: 100%;">';
                        echo '<img src="../crud/monitoriai/uploads/' . $row["photos"] . '" class="card-img-top" alt="Product Image" style="object-fit: cover; height: 100%;">';
                        echo '<div class="card-body" style="flex-grow: 1;">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text" style="margin-bottom: auto;">' . $row["kaina"] . '</p>';
                        echo '<p class="card-text" style="margin-bottom: auto;">' . $row["ekrano_istrizaine"] . '</p>';
                        echo '<p class="card-text" style="margin-bottom: auto;">' . $row["rezoliucija"] . '</p>';
                        echo '<p class="card-text" style="margin-bottom: auto;">' . $row["lieciamas_ekranas"] . '</p>';
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
    <script>
  // Select the form and add an event listener to detect changes
  const form = document.getElementById('filter-form');
  form.addEventListener('change', handleFormChange);

  function handleFormChange(event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Get the form data and send an AJAX request
    const formData = new FormData(form);
    fetch('filter.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      // Update the product list in the DOM with the new data
      const productList = document.querySelector('.product-list');
      productList.innerHTML = data;
    })
    .catch(error => console.error(error));
  }
</script>
</body>

</html>