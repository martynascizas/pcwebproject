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

                    <div id="filterContainer" style="width: 50vw; margin: 0 auto;">
                        <!--Generate select options for gamintojas-->
                        <label for="gamintojas" class="form-label">Gamintojas</label>
                        <select class="form-select" id="gamintojas" name="gamintojas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $pavadinimas = $_POST['pavadinimas'];
                            $aprasymas = $_POST['aprasymas'];
                            if (!empty($pavadinimas) || !empty($aprasymas))
                                $sql = "SELECT gamintojas, COUNT(*) AS total 
                                     FROM kompiuteriu_priedai 
                                     WHERE pavadinimas = '$pavadinimas' || aprasymas = '$aprasymas'
                                     GROUP BY gamintojas 
                                     ORDER BY gamintojas ASC";
                            else {
                                $sql = "SELECT gamintojas, COUNT(*) AS total FROM kompiuteriu_priedai GROUP BY gamintojas ORDER BY gamintojas ASC";
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

                        <!--Generate select options for pavadinimas-->
                        <label for="pavadinimas" class="form-label">pavadinimas</label>
                        <select class="form-select" id="pavadinimas" name="pavadinimas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $gamintojas = $_POST['gamintojas'];
                            $aprasymas = $_POST['aprasymas'];
                            if (!empty($gamintojas) || !empty($aprasymas))
                                $sql = "SELECT pavadinimas, COUNT(*) AS total 
                                     FROM kompiuteriu_priedai 
                                     WHERE gamintojas = '$gamintojas' || aprasymas = '$aprasymas'
                                     GROUP BY pavadinimas 
                                     ORDER BY pavadinimas ASC";
                            else {
                                $sql = "SELECT pavadinimas, COUNT(*) AS total FROM kompiuteriu_priedai GROUP BY pavadinimas ORDER BY pavadinimas ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['pavadinimas'] == $row['pavadinimas']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["pavadinimas"] . '" ' . $selected . '>' . $row["pavadinimas"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for aprasymas-->
                        <label for="aprasymas" class="form-label">aprasymas</label>
                        <select class="form-select" id="aprasymas" name="aprasymas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $gamintojas = $_POST['gamintojas'];
                            $pavadinimas = $_POST['pavadinimas'];
                            if (!empty($gamintojas) || !empty($pavadinimas))
                                $sql = "SELECT aprasymas, COUNT(*) AS total 
                                     FROM kompiuteriu_priedai 
                                     WHERE gamintojas = '$gamintojas' || pavadinimas = '$pavadinimas'
                                     GROUP BY pavadinimas 
                                     ORDER BY pavadinimas ASC";
                            else {
                                $sql = "SELECT aprasymas, COUNT(*) AS total FROM kompiuteriu_priedai GROUP BY aprasymas ORDER BY aprasymas ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['aprasymas'] == $row['aprasymas']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["aprasymas"] . '" ' . $selected . '>' . $row["aprasymas"] . ' (' . $row["total"] . ')</option>';
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
                            <input type="range" class="form-range" id="kaina_iki" name="kaina_iki" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1" value="<?php echo isset($_POST['kaina_iki']) ? $_POST['kaina_iki'] : $max_kaina; ?>">
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                            <button id="submit_btn" type="submit" class="btn btn-primary mb-4" name="filter_submit">Filtruoti</button>
                            <button id="clear_btn" type="button" class="btn btn-secondary mb-4">Išvalyti</button>
                            <script>
                                document.getElementById("clear_btn").addEventListener("click", function() {
                                    document.getElementById("gamintojas").value = "";
                                    document.getElementById("pavadinimas").value = "";
                                    document.getElementById("aprasymas").value = "";
                                    document.getElementById("kaina_nuo").value = <?php echo $min_kaina; ?>;
                                    document.getElementById("kaina_iki").value = <?php echo $max_kaina; ?>;
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
                        echo '<p class="card-text">' . "Pavadinimas: " . $row["pavadinimas"] . '</p>';
                        echo '<p class="card-text">' . "Aprašymas: " . $row["aprasymas"] . '</p>';
                        echo '<p class="card-text">' . "Prekės kodas: PRI" . $row["id"] . '</p>';
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