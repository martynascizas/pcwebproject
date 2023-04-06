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
            <h3 id="kompiuteriu_priedai" class="text-center mb-5">Kompiuterių Priedai</h3>
            <form id="filter-form" method="POST">
                <div class="mb-3">
                    <?php
                    // Construct SQL query with the selected gamintojas value
                    $sql = "SELECT m.id, m.gamintojas, m.pavadinimas, m.aprasymas, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') 
                    AS photos
                    FROM kompiuteriu_priedai m 
                    LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id";
                    if (!empty($gamintojas) || !empty($kaina)) {
                        $sql .= " WHERE ";
                        if (!empty($gamintojas)) {
                            $sql .= "gamintojas = '$gamintojas' AND ";
                        }
                        if (!empty($pavadinimas)) {
                            $sql .= "pavadinimas = '$pavadinimas' AND ";
                        }
                        if (!empty($aprasymas)) {
                            $sql .= "aprasymas = '$aprasymas' AND ";
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

                    <div id="filterContainer" style="width: 20vw!important;">
                        <!--Generate select options for gamintojas-->
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
                          
                        <!--Generate select options for pavadinimas-->
                        <div id="filterContainer" style="width: 20vw!important;">
                        <!--Generate select options for pavadinimas-->
                        <label for="pavadinimas" class="form-label">pavadinimas</label>
                        <select class="form-select" id="pavadinimas" name="pavadinimas">
                            <option value="">Visi</option>
                            <?php
                            // Reset the pointer of the result set to the beginning
                            mysqli_data_seek($result, 0);
                            // Loop through result set and generate options
                            $selected_values = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['pavadinimas'] == $row['pavadinimas']) {
                                    $selected = 'selected';
                                }
                                if (!in_array($row['pavadinimas'], $selected_values)) {
                                    echo '<option value="' . $row["pavadinimas"] . '" ' . $selected . '>' . $row["pavadinimas"] . '</option>';
                                    $selected_values[] = $row['pavadinimas'];
                                }
                            }
                            ?>
                        </select>
                    
                  <!--Generate select options for aprasymas-->
                  <div id="filterContainer" style="width: 20vw!important;">
                        <!--Generate select options for aprasymas-->
                        <label for="aprasymas" class="form-label">aprasymas</label>
                        <select class="form-select" id="aprasymas" name="aprasymas">
                            <option value="">Visi</option>
                            <?php
                            // Reset the pointer of the result set to the beginning
                            mysqli_data_seek($result, 0);
                            // Loop through result set and generate options
                            $selected_values = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['aprasymas'] == $row['aprasymas']) {
                                    $selected = 'selected';
                                }
                                if (!in_array($row['aprasymas'], $selected_values)) {
                                    echo '<option value="' . $row["aprasymas"] . '" ' . $selected . '>' . $row["aprasymas"] . '</option>';
                                    $selected_values[] = $row['aprasymas'];
                                }
                            }
                            ?>
                        </select>

                        <!--Generate select options for kaina-->
                        <div class="form-group">
                            <?php
                            // Get the minimum and maximum kaina values from the database
                            $sql = "SELECT MIN(kaina) AS min_kaina, MAX(kaina) AS max_kaina FROM kompiuteriu_priedai";
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
                        <button type="submit" class="btn btn-primary mb-5" name="filter_submit">Filtruoti</button>
                    </div>
            </form>

            <?php
            // Check if form has been submitted
            if (isset($_POST['filter_submit'])) {
                // Get the selected gamintojas and ekrano_istrizaine values from the form
                $gamintojas = $_POST['gamintojas'];
                $pavadinimas = $_POST['pavadinimas'];
                $aprasymas = $_POST['aprasymas'];
                if (isset($_POST['kaina_nuo'])) {
                    $min_kaina = $_POST['kaina_nuo'];
                }
                if (isset($_POST['kaina_iki'])) {
                    $max_kaina = $_POST['kaina_iki'];
                }

                $sql = "SELECT m.id, m.gamintojas, m.pavadinimas, m.aprasymas, m.kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos
                FROM kompiuteriu_priedai m 
                LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id";

                // Loop all possible conditions
                $where_conditions = [];

                if (!empty($gamintojas)) {
                    $where_conditions[] = "gamintojas = '$gamintojas'";
                }

                if (!empty($pavadinimas)) {
                    $where_conditions[] = "pavadinimas = '$pavadinimas'";
                }

                if (!empty($aprasymas)) {
                    $where_conditions[] = "aprasymas = '$aprasymas'";
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
                        echo '<img src="../crud/kompiuteriu_priedai/uploads/' . $row["photos"] . '" class="card-img-top" alt="Product Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<h5 class="card-title">' . $row["pavadinimas"] . '</h5>';
                        echo '<h5 class="card-title">' . $row["aprasymas"] . '</h5>';
                        echo '<p class="card-text">' . $row["kaina"] . '</p>';
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
        </div>

    </div>

    </div>
    <?php
    require_once 'footer.php';
    ?>
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