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
            <h3 id="nesiojami_kompiuteriai" class="text-center mb-5">Nešiojami Kompiuteriai</h3>
            <form id="filter-form" method="POST">
                <div class="mb-3">
                    <?php
                    // Construct SQL query with the selected gamintojas value
                    $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') 
                    AS photos
                    FROM nesiojami_kompiuteriai m 
                    LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id";
                    if (!empty($gamintojas) || !empty($ekrano_istrizaine) || !empty($procesorius) || !empty($vaizdo_plokste) || !empty($ram) || !empty($hdd) || !empty($kaina)) {
                        $sql .= " WHERE ";
                        if (!empty($gamintojas)) {
                            $sql .= "gamintojas = '$gamintojas' AND ";
                        }
                        if (!empty($ekrano_istrizaine)) {
                            $sql .= "ekrano_istrizaine = '$ekrano_istrizaine' AND ";
                        }
                        if (!empty($procesorius)) {
                            $sql .= "procesorius = '$procesorius' AND ";
                        }
                        if (!empty($vaizdo_plokste)) {
                            $sql .= "vaizdo_plokste = '$vaizdo_plokste' AND ";
                        }
                        if (!empty($ram)) {
                            $sql .= "ram = '$ram' AND ";
                        }
                        if (!empty($hdd)) {
                            $sql .= "hdd = '$hdd' AND ";
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
                            $procesorius = $_POST['procesorius'];
                            $vaizdo_plokste = $_POST['vaizdo_plokste'];
                            $ram = $_POST['ram'];
                            $hdd = $_POST['hdd'];
                            if (!empty($ekrano_istrizaine) || !empty($procesorius) || !empty($vaizdo_plokste) || !empty($hdd) || !empty($ram))
                                $sql = "SELECT gamintojas, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE ekrano_istrizaine = '$ekrano_istrizaine' || procesorius = '$procesorius' || vaizdo_plokste = '$vaizdo_plokste' || ram = '$ram' || hdd = '$hdd'
                                        GROUP BY gamintojas 
                                        ORDER BY gamintojas ASC";
                            else {
                                $sql = "SELECT gamintojas, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY gamintojas ORDER BY gamintojas ASC";
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
                            $selected_gamintojas = $_POST['gamintojas'];
                            $procesorius = $_POST['procesorius'];
                            $vaizdo_plokste = $_POST['vaizdo_plokste'];
                            $ram = $_POST['ram'];
                            $hdd = $_POST['hdd'];
                            if (!empty($selected_gamintojas) || !empty($procesorius) || !empty($vaizdo_plokste) || !empty($ram) || !empty($hdd))
                                $sql = "SELECT ekrano_istrizaine, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE gamintojas = '$selected_gamintojas' || procesorius = '$procesorius' || vaizdo_plokste = '$vaizdo_plokste' || ram = '$ram' || hdd = '$hdd'
                                        GROUP BY ekrano_istrizaine 
                                        ORDER BY ekrano_istrizaine ASC";
                            else {
                                $sql = "SELECT ekrano_istrizaine, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY ekrano_istrizaine ORDER BY ekrano_istrizaine ASC";
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

                        <!--Generate select options for procesorius-->
                        <label for="procesorius" class="form-label">Procesorius</label>
                        <select class="form-select" id="procesorius" name="procesorius">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results       
                            $selected_gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $vaizdo_plokste = $_POST['vaizdo_plokste'];
                            $ram = $_POST['ram'];
                            $hdd = $_POST['hdd'];
                            if (!empty($selected_gamintojas) || !empty($ekrano_istrizaine) || !empty($vaizdo_plokste) || !empty($ram) || !empty($hdd))
                                $sql = "SELECT procesorius, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE gamintojas = '$selected_gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine' || vaizdo_plokste = '$vaizdo_plokste' || ram = '$ram' || hdd = '$hdd'
                                        GROUP BY procesorius 
                                        ORDER BY procesorius ASC";
                            else {
                                $sql = "SELECT procesorius, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY procesorius ORDER BY procesorius ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['procesorius'] == $row['procesorius']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["procesorius"] . '" ' . $selected . '>' . $row["procesorius"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for vaizdo_plokste-->
                        <label for="vaizdo_plokste" class="form-label">Vaizdo Plokštė</label>
                        <select class="form-select" id="vaizdo_plokste" name="vaizdo_plokste">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $procesorius = $_POST['procesorius'];
                            $ram = $_POST['ram'];
                            $hdd = $_POST['hdd'];
                            if (!empty($selected_gamintojas) || !empty($ekrano_istrizaine) || !empty($procesorius) || !empty($ram) || !empty($hdd))
                                $sql = "SELECT vaizdo_plokste, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE gamintojas = '$selected_gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine' || procesorius = '$procesorius' || ram = '$ram' || hdd = '$hdd'
                                        GROUP BY vaizdo_plokste 
                                        ORDER BY vaizdo_plokste ASC";
                            else {
                                $sql = "SELECT vaizdo_plokste, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY vaizdo_plokste ORDER BY vaizdo_plokste ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['vaizdo_plokste'] == $row['vaizdo_plokste']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["vaizdo_plokste"] . '" ' . $selected . '>' . $row["vaizdo_plokste"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for ram-->
                        <label for="ram" class="form-label">RAM</label>
                        <select class="form-select" id="ram" name="ram">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $procesorius = $_POST['procesorius'];
                            $vaizdo_plokste = $_POST['vaizdo_plokste'];
                            $hdd = $_POST['hdd'];
                            if (!empty($selected_gamintojas) || !empty($ekrano_istrizaine) || !empty($procesorius) || !empty($vaizdo_plokste) || !empty($hdd))
                                $sql = "SELECT ram, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE gamintojas = '$selected_gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine' || procesorius = '$procesorius' || vaizdo_plokste = '$vaizdo_plokste' || hdd = '$hdd'
                                        GROUP BY ram 
                                        ORDER BY ram ASC";
                            else {
                                $sql = "SELECT ram, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY ram ORDER BY ram ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['ram'] == $row['ram']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["ram"] . '" ' . $selected . '>' . $row["ram"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for hdd-->
                        <label for="hdd" class="form-label">HDD</label>
                        <select class="form-select" id="hdd" name="hdd">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            $procesorius = $_POST['procesorius'];
                            $vaizdo_plokste = $_POST['vaizdo_plokste'];
                            $ram = $_POST['ram'];
                            if (!empty($selected_gamintojas) || !empty($ekrano_istrizaine) || !empty($procesorius) || !empty($vaizdo_plokste) || !empty($ram))
                                $sql = "SELECT hdd, COUNT(*) AS total 
                                        FROM nesiojami_kompiuteriai 
                                        WHERE gamintojas = '$selected_gamintojas' || ekrano_istrizaine = '$ekrano_istrizaine' || procesorius = '$procesorius' || vaizdo_plokste = '$vaizdo_plokste' || ram = '$ram'
                                        GROUP BY hdd 
                                        ORDER BY hdd ASC";
                            else {
                                $sql = "SELECT hdd, COUNT(*) AS total FROM nesiojami_kompiuteriai GROUP BY hdd ORDER BY hdd ASC";
                            }
                            $result = mysqli_query($conn, $sql);

                            // Loop through result set and generate options
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if ($_POST['hdd'] == $row['hdd']) {
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $row["hdd"] . '" ' . $selected . '>' . $row["hdd"] . ' (' . $row["total"] . ')</option>';
                            }
                            ?>
                        </select>

                        <!--Generate select options for kaina-->
                        <div class="form-group">
                            <?php
                            // Get the minimum and maximum kaina values from the database
                            $sql = "SELECT MIN(kaina) AS min_kaina, MAX(kaina) AS max_kaina FROM nesiojami_kompiuteriai";
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
                                    document.getElementById("ekrano_istrizaine").value = "";
                                    document.getElementById("procesorius").value = "";
                                    document.getElementById("vaizdo_plokste").value = "";
                                    document.getElementById("ram").value = "";
                                    document.getElementById("hdd").value = "";
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
                $procesorius = $_POST['procesorius'];
                $vaizdo_plokste = $_POST['vaizdo_plokste'];
                $ram = $_POST['ram'];
                $hdd = $_POST['hdd'];
                if (isset($_POST['kaina_nuo'])) {
                    $min_kaina = $_POST['kaina_nuo'];
                }
                if (isset($_POST['kaina_iki'])) {
                    $max_kaina = $_POST['kaina_iki'];
                }

                $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos
                FROM nesiojami_kompiuteriai m 
                LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id";

                // Loop all possible conditions
                $where_conditions = [];

                if (!empty($gamintojas)) {
                    $where_conditions[] = "gamintojas = '$gamintojas'";
                }

                if (!empty($ekrano_istrizaine)) {
                    $where_conditions[] = "ekrano_istrizaine = '$ekrano_istrizaine'";
                }

                if (!empty($procesorius)) {
                    $where_conditions[] = "procesorius = '$procesorius'";
                }

                if (!empty($vaizdo_plokste)) {
                    $where_conditions[] = "vaizdo_plokste = '$vaizdo_plokste'";
                }

                if (!empty($ram)) {
                    $where_conditions[] = "ram = '$ram'";
                }

                if (!empty($hdd)) {
                    $where_conditions[] = "hdd = '$hdd'";
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
                        echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                        echo '<div class="carousel-inner">';

                        // Loop through all photos and create carousel items
                        $photos = explode(",", $row["photos"]);
                        for ($i = 0; $i < count($photos); $i++) {
                            if ($i == 0) {
                                echo '<div class="carousel-item active">';
                            } else {
                                echo '<div class="carousel-item">';
                            }
                            echo '<div class="m-4"><img src="../crud/nesiojami_kompiuteriai/uploads/' . $photos[$i] . '" class="d-block w-100 zoomable" alt="Product Image"></div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="prev">';
                        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                        echo '<span class="visually-hidden">Previous</span>';
                        echo '</button>';
                        echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="next">';
                        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                        echo '<span class="visually-hidden">Next</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<div class="card-body d-flex flex-column justify-content-end">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">' . "Ekrano Įstrižainė: " . $row["ekrano_istrizaine"] . "\"" . '</p>';
                        echo '<p class="card-text">' . "Procesorius: " . $row["procesorius"] . '</p>';
                        echo '<p class="card-text">' . "Vaizdo plokštė: " . $row["vaizdo_plokste"] . '</p>';
                        echo '<p class="card-text">' . "Operatyvioji atmintis (RAM): " . $row["ram"] . '</p>';
                        echo '<p class="card-text">' . "Kietasis diskas (HDD): " . $row["hdd"] . '</p>';
                        echo '<p class="card-text">' . "Prekės kodas: NES" . $row["id"] . '</p>';
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
    <!-- footer -->
    <?php
    require_once 'footer.php';
    ?>
    </div>
    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>

    <!--img zoom-->
    <script>
        const zoomableImages = document.querySelectorAll('.zoomable');
        zoomableImages.forEach(image => {
            image.addEventListener('click', e => {
                e.target.classList.toggle('active');
                document.body.classList.toggle('no-scroll');
                const exitBtn = document.createElement('button');
                exitBtn.innerHTML = 'Exit';
                exitBtn.classList.add('exit-btn');
                document.body.appendChild(exitBtn);
                exitBtn.addEventListener('click', () => {
                    e.target.classList.remove('active');
                    document.body.classList.remove('no-scroll');
                    exitBtn.remove();
                });
            });
        });
    </script>

    <!--filter-->
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

    <!--price range-->
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