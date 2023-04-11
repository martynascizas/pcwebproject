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
                    ?>

                    <div id="filterContainer" style="width: 50vw; margin: 0 auto;">
                        <!--Generate select options for gamintojas-->
                        <label for="gamintojas" class="form-label">Gamintojas</label>
                        <select class="form-select" id="gamintojas" name="gamintojas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $rezoliucija = $_POST['rezoliucija'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            if (!empty($ekrano_istrizaine) || !empty($rezoliucija) || !empty($lieciamas_ekranas))
                                $sql = "SELECT gamintojas, COUNT(*) AS total 
                                     FROM monitoriai 
                                     WHERE lieciamas_ekranas = '$lieciamas_ekranas' || ekrano_istrizaine = '$ekrano_istrizaine' || rezoliucija = '$rezoliucija'
                                     GROUP BY gamintojas 
                                     ORDER BY gamintojas ASC";
                            else {
                                $sql = "SELECT gamintojas, COUNT(*) AS total FROM monitoriai GROUP BY gamintojas ORDER BY gamintojas ASC";
                            }
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

                        <!--Generate select options for ekrano_istrizaine-->
                        <label for="ekrano_istrizaine" class="form-label">Ekrano įstrižainė</label>
                        <select class="form-select" id="ekrano_istrizaine" name="ekrano_istrizaine">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $gamintojas = $_POST['gamintojas'];
                            $rezoliucija = $_POST['rezoliucija'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            if (!empty($gamintojas) || !empty($rezoliucija) || !empty($lieciamas_ekranas))
                                $sql = "SELECT ekrano_istrizaine, COUNT(*) AS total 
                                     FROM monitoriai 
                                     WHERE lieciamas_ekranas = '$lieciamas_ekranas' || gamintojas = '$gamintojas' || rezoliucija = '$rezoliucija'
                                     GROUP BY ekrano_istrizaine 
                                     ORDER BY ekrano_istrizaine ASC";
                            else {
                                $sql = "SELECT ekrano_istrizaine, COUNT(*) AS total FROM monitoriai GROUP BY ekrano_istrizaine ORDER BY ekrano_istrizaine ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['ekrano_istrizaine'] == $row['ekrano_istrizaine']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["ekrano_istrizaine"] . '" ' . $selected . '>' . $row["ekrano_istrizaine"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for rezoliucija-->
                        <label for="rezoliucija" class="form-label">Rezoliucija</label>
                        <select class="form-select" id="rezoliucija" name="rezoliucija">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            if (!empty($gamintojas) || !empty($ekrano_istrizaine) || !empty($lieciamas_ekranas))
                                $sql = "SELECT rezoliucija, COUNT(*) AS total 
                                     FROM monitoriai 
                                     WHERE lieciamas_ekranas = '$lieciamas_ekranas' || gamintojas = '$gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine'
                                     GROUP BY rezoliucija 
                                     ORDER BY rezoliucija ASC";
                            else {
                                $sql = "SELECT rezoliucija, COUNT(*) AS total FROM monitoriai GROUP BY rezoliucija ORDER BY rezoliucija ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['rezoliucija'] == $row['rezoliucija']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["rezoliucija"] . '" ' . $selected . '>' . $row["rezoliucija"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for lieciamas_ekranas-->
                        <label for="lieciamas_ekranas" class="form-label">Lieciamas ekranas</label>
                        <select class="form-select" id="lieciamas_ekranas" name="lieciamas_ekranas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $rezoliucija = $_POST['rezoliucija'];
                            if (!empty($gamintojas) || !empty($ekrano_istrizaine) || !empty($rezoliucija))
                                $sql = "SELECT lieciamas_ekranas, COUNT(*) AS total 
                                     FROM monitoriai 
                                     WHERE rezoliucija = '$rezoliucija' || gamintojas = '$gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine'
                                     GROUP BY lieciamas_ekranas 
                                     ORDER BY lieciamas_ekranas ASC";
                            else {
                                $sql = "SELECT lieciamas_ekranas, COUNT(*) AS total FROM monitoriai GROUP BY lieciamas_ekranas ORDER BY lieciamas_ekranas ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['lieciamas_ekranas'] == $row['lieciamas_ekranas']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["lieciamas_ekranas"] . '" ' . $selected . '>' . $row["lieciamas_ekranas"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for kaina-->
                        <div class="form-group">
                            <?php
                            // Get the minimum and maximum kaina values from the database
                            $sql = "SELECT MIN(kaina) AS min_kaina, MAX(kaina) AS max_kaina FROM monitoriai";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $min_kaina = $row['min_kaina'];
                            $max_kaina = $row['max_kaina'];
                            ?>
                            <label for="kaina" class="form-label">Kaina nuo: <span id="kaina_nuo_value"><?php echo isset($_POST['kaina_nuo']) ? $_POST['kaina_nuo'] : $min_kaina; ?></span></label>
                            <input type="range" class="form-range" id="kaina_nuo" name="kaina_nuo" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1" value="<?php echo isset($_POST['kaina_nuo']) ? $_POST['kaina_nuo'] : $min_kaina; ?>">

                            <label for="kaina" class="form-label">Kaina iki: <span id="kaina_iki_value"><?php echo isset($_POST['kaina_iki']) ? $_POST['kaina_iki'] : $max_kaina; ?></span></label>
                            <input type="range" class="form-range" id="kaina_iki" name="kaina_iki" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1" value="<?php echo $max_kaina; ?>">
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                            <button id="submit_btn" type="submit" class="btn btn-primary mb-4" name="filter_submit">Filtruoti</button>
                            <button id="clear_btn" type="button" class="btn btn-secondary mb-4">Išvalyti</button>
                            <script>
                                document.getElementById("clear_btn").addEventListener("click", function() {
                                    document.getElementById("gamintojas").value = "";
                                    document.getElementById("ekrano_istrizaine").value = "";
                                    document.getElementById("rezoliucija").value = "";
                                    document.getElementById("lieciamas_ekranas").value = "";
                                    document.getElementById("submit_btn").click();
                                });
                            </script>
                        </div>
                    </div>
            </form>

            <?php
            // Check if form has been submitted
            if (isset($_POST['filter_submit'])) {
                // Get the selected gamintojas and ekrano_istrizaine values from the form
                $gamintojas = $_POST['gamintojas'];
                $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                $rezoliucija = $_POST['rezoliucija'];
                $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                if (isset($_POST['kaina_nuo'])) {
                    $min_kaina = $_POST['kaina_nuo'];
                }
                if (isset($_POST['kaina_iki'])) {
                    $max_kaina = $_POST['kaina_iki'];
                }

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

                if (!empty($min_kaina) && !empty($max_kaina)) {
                    $where_conditions[] = "kaina BETWEEN $min_kaina AND $max_kaina";
                } elseif (!empty($min_kaina)) {
                    $where_conditions[] = "kaina >= $min_kaina";
                } elseif (!empty($max_kaina)) {
                    $where_conditions[] = "kaina <= $max_kaina";
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
                        echo '<div class="card h-100">';
                        echo '<img src="../crud/monitoriai/uploads/' . $row["photos"] . '" class="card-img-top" alt="Product Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">' . "Ekrano įstrižainė: " . $row["ekrano_istrizaine"] . "\"" . '</p>';
                        echo '<p class="card-text">' . "Rezoliucija: " . $row["rezoliucija"] . '</p>';
                        echo '<p class="card-text">' . "Liečiamas ekranas: " . $row["lieciamas_ekranas"] . '</p>';
                        echo '<p class="card-text">' . "Prekės kodas: MON" . $row["id"] . '</p>';
                        echo '</div>';
                        echo '<div class="card-footer">';
                        echo '<p class="card-text">' . "Kaina: " . $row["kaina"] . "Eur" . '</p>';
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
    </div>
    <?php
    require_once 'footer.php';
    ?>
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

    <script>
        // Get the range input elements
        const kainaNuo = document.getElementById('kaina_nuo');
        const kainaIki = document.getElementById('kaina_iki');

        // Get the span elements to display the selected values
        const kainaNuoValue = document.getElementById('kaina_nuo_value');
        const kainaIkiValue = document.getElementById('kaina_iki_value');

        // Add event listeners to update the span elements in real-time
        kainaNuo.addEventListener('input', function() {
            if (parseInt(kainaNuo.value) > parseInt(kainaIki.value)) {
                kainaNuo.value = kainaIki.value;
            }
            kainaNuoValue.textContent = kainaNuo.value;
        });
        kainaIki.addEventListener('input', function() {
            if (parseInt(kainaIki.value) < parseInt(kainaNuo.value)) {
                kainaIki.value = kainaNuo.value;
            }
            kainaIkiValue.textContent = kainaIki.value;
        });
    </script>
</body>

</html>