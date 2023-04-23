<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once 'assets/prodhead.php';
    ?>
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['windowHasLoaded'])) {
        $_SESSION['windowHasLoaded'] = true;
    } else {
        echo '<script>window.onload = function () { document.getElementById("sid").click(); };</script>';
    }
    ?>
    <!-- navbar -->
    <?php
    require_once 'assets/prodnav.php';
    ?>
    <?php
    require '../db.php';
    ?>

    <div id="offcanvas" class="offcanvas offcanvas-start w-25 p-3" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title d-none d-sm-block" id="offcanvas">Filtrai</h6>
            <button id="clodeBtn" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <?php
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Construct SQL query with the selected gamintojas value
        $sql = "SELECT m.id, m.gamintojas, m.rezoliucija, m.lieciamas_ekranas, m.ekrano_istrizaine, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') 
                    AS photos
                    FROM monitoriai m 
                    LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id";
        if (!empty($gamintojas) || !empty($rezoliucija) || !empty($lieciamas_ekranas) || !empty($ekrano_istrizaine) || !empty($kaina)) {
            $sql .= " WHERE ";
            if (!empty($gamintojas)) {
                $sql .= "gamintojas = '$gamintojas' AND ";
            }
            if (!empty($rezoliucija)) {
                $sql .= "rezoliucija = '$rezoliucija' AND ";
            }
            if (!empty($lieciamas_ekranas)) {
                $sql .= "lieciamas_ekranas = '$lieciamas_ekranas' AND ";
            }
            if (!empty($ekrano_istrizaine)) {
                $sql .= "ekrano_istrizaine = '$ekrano_istrizaine' AND ";
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
        <div class="offcanvas-body px-0">
            <form id="filter-form" class="align" method="POST">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 " id="menu">
                    <li>
                        <!--Generate select options for gamintojas-->
                        <label for="gamintojas" class="form-label">Gamintojas</label>
                        <select class="form-select" id="gamintojas" name="gamintojas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $rezoliucija = $_POST['rezoliucija'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            if (!empty($rezoliucija) || !empty($lieciamas_ekranas) || !empty($ekrano_istrizaine))
                                $sql = "SELECT gamintojas, COUNT(*) AS total 
                                        FROM monitoriai 
                                        WHERE  rezoliucija = '$rezoliucija' || lieciamas_ekranas = '$lieciamas_ekranas' || ekrano_istrizaine = '$ekrano_istrizaine'
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
                    </li>
                    <li>
                        <!--Generate select options for rezoliucija-->
                        <label for="rezoliucija" class="form-label">Rezoliucija</label>
                        <select class="form-select" id="rezoliucija" name="rezoliucija">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results       
                            $selected_gamintojas = $_POST['gamintojas'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            if (!empty($selected_gamintojas) ||  !empty($lieciamas_ekranas) || !empty($ekrano_istrizaine))
                                $sql = "SELECT rezoliucija, COUNT(*) AS total 
                                        FROM monitoriai 
                                        WHERE gamintojas = '$selected_gamintojas' || lieciamas_ekranas = '$lieciamas_ekranas' || ekrano_istrizaine = '$ekrano_istrizaine'
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
                    </li>
                    <li>
                        <!--Generate select options for lieciamas_ekranas-->
                        <label for="lieciamas_ekranas" class="form-label">Vaizdo Plokštė</label>
                        <select class="form-select" id="lieciamas_ekranas" name="lieciamas_ekranas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $rezoliucija = $_POST['rezoliucija'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            if (!empty($selected_gamintojas) || !empty($rezoliucija) || !empty($ekrano_istrizaine))
                                $sql = "SELECT lieciamas_ekranas, COUNT(*) AS total 
                                        FROM monitoriai 
                                        WHERE gamintojas = '$selected_gamintojas' ||  rezoliucija = '$rezoliucija' || ekrano_istrizaine = '$ekrano_istrizaine'
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
                    </li>
                    <li>
                        <!--Generate select options for ekrano_istrizaine-->
                        <label for="ekrano_istrizaine" class="form-label">Ekrano Įstrižainė</label>
                        <select class="form-select" id="ekrano_istrizaine" name="ekrano_istrizaine">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $rezoliucija = $_POST['rezoliucija'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            if (!empty($selected_gamintojas) || !empty($rezoliucija) || !empty($lieciamas_ekranas))
                                $sql = "SELECT ekrano_istrizaine, COUNT(*) AS total 
                                        FROM monitoriai 
                                        WHERE gamintojas = '$selected_gamintojas'|| rezoliucija = '$rezoliucija' || lieciamas_ekranas = '$lieciamas_ekranas'
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
                    </li>
                    <li>
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
                            <input type="range" class="form-range" id="kaina_iki" name="kaina_iki" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1" value="<?php echo isset($_POST['kaina_iki']) ? $_POST['kaina_iki'] : $max_kaina; ?>">
                        </div>
                    </li>
                    <li>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                            <button id="submit_btn" type="submit" class="btn btn-primary mb-4 d-none" name="filter_submit">Filtruoti</button>
                            <button id="clear_btn" type="button" class="btn btn-secondary mb-4">Išvalyti</button>
                            <script>
                                document.getElementById("clear_btn").addEventListener("click", function() {
                                    document.getElementById("gamintojas").value = "";
                                    document.getElementById("rezoliucija").value = "";
                                    document.getElementById("lieciamas_ekranas").value = "";
                                    document.getElementById("ekrano_istrizaine").value = "";
                                    document.getElementById("kaina_nuo").value = <?php echo $min_kaina; ?>;
                                    document.getElementById("kaina_iki").value = <?php echo $max_kaina; ?>;
                                    document.getElementById("submit_btn").click();
                                });
                            </script>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col min-vh-100 py-3">
                <!-- toggler -->
                <button id="sid" class="btn sidebar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button">
                    <i class="bi bi-filter fs-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
                </button>
                <div class="wrapper">
                    <div class="container products_section products-margin">
                        <h3 id="monitoriai" class="text-center mb-5">Monitoriai</h3>
                        <?php
                        // Check if form has been submitted
                        if (!isset($_POST['filter_submit'])) {
                            // Perform the JOIN between the tables
                            $sql = "SELECT nk.*, GROUP_CONCAT(nkp.filename) AS photos
                FROM monitoriai nk
                LEFT JOIN monitoriai_photos nkp ON nk.id = nkp.monitoriai_id
                GROUP BY nk.id
                ORDER BY nk.timestamp DESC";

                            $result = mysqli_query($conn, $sql);
                            // Generate the HTML markup for the products
                            echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $photos = explode(",", $row["photos"]);
                                $carousel_items = '';
                                foreach ($photos as $i => $photo) {
                                    $active_class = ($i == 0) ? 'active' : '';
                                    $carousel_items .= '<div class="carousel-item ' . $active_class . '">';
                                    $carousel_items .= '<div class="m-4"><a href="../crud/monitoriai/uploads/' . $photo . '" data-fancybox="gallery' . $row["id"] . '"><img src="../crud/monitoriai/uploads/' . $photo . '" class="d-block w-100 zoomable" alt="Product Image"></a></div>';
                                    $carousel_items .= '</div>';
                                }

                                echo '<div class="col">';
                                echo '<div class="card h-100">';
                                echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                                echo '<div class="carousel-inner">' . $carousel_items . '</div>';
                                echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>';
                                echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>';
                                echo '</div>';
                                echo '<div class="card-body d-flex flex-column justify-content-end">';
                                echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                                echo '<p class="card-text">' . "Rezoliucija: " . $row["rezoliucija"] . '</p>';
                                echo '<p class="card-text">' . "Vaizdo plokštė: " . $row["lieciamas_ekranas"] . '</p>';
                                echo '<p class="card-text">' . "Operatyvioji atmintis (ekrano_istrizaine): " . $row["ekrano_istrizaine"] . '</p>';
                                echo '<p class="card-text">' . "Prekės kodas: MON00" . $row["id"] . '</p>';
                                echo '</div>';
                                echo '<div class="card-footer">';
                                echo '<p class="card-text">' . "Kaina: " . $row["kaina"] . "Eur" . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else if (isset($_POST['filter_submit'])) {
                            // Get the selected gamintojas and ekrano_istrizaine values from the form
                            $gamintojas = $_POST['gamintojas'];
                            $rezoliucija = $_POST['rezoliucija'];
                            $lieciamas_ekranas = $_POST['lieciamas_ekranas'];
                            $ekrano_istrizaine = $_POST['ekrano_istrizaine'];
                            if (isset($_POST['kaina_nuo'])) {
                                $min_kaina = $_POST['kaina_nuo'];
                            }
                            if (isset($_POST['kaina_iki'])) {
                                $max_kaina = $_POST['kaina_iki'];
                            }

                            $sql = "SELECT m.id, m.gamintojas, m.rezoliucija, m.lieciamas_ekranas, m.ekrano_istrizaine, m.kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos
                FROM monitoriai m 
                LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id";

                            // Loop all possible conditions
                            $where_conditions = [];

                            if (!empty($gamintojas)) {
                                $where_conditions[] = "gamintojas = '$gamintojas'";
                            }

                            if (!empty($rezoliucija)) {
                                $where_conditions[] = "rezoliucija = '$rezoliucija'";
                            }

                            if (!empty($lieciamas_ekranas)) {
                                $where_conditions[] = "lieciamas_ekranas = '$lieciamas_ekranas'";
                            }

                            if (!empty($ekrano_istrizaine)) {
                                $where_conditions[] = "ekrano_istrizaine = '$ekrano_istrizaine'";
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
                                    $photos = explode(",", $row["photos"]);
                                    $carousel_items = '';
                                    foreach ($photos as $i => $photo) {
                                        $active_class = ($i == 0) ? 'active' : '';
                                        $carousel_items .= '<div class="carousel-item ' . $active_class . '">';
                                        $carousel_items .= '<div class="m-4"><a href="../crud/monitoriai/uploads/' . $photo . '" data-fancybox="gallery' . $row["id"] . '"><img src="../crud/monitoriai/uploads/' . $photo . '" class="d-block w-100 zoomable" alt="Product Image"></a></div>';
                                        $carousel_items .= '</div>';
                                    }

                                    echo '<div class="col">';
                                    echo '<div class="card h-100">';
                                    echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                                    echo '<div class="carousel-inner">' . $carousel_items . '</div>';
                                    echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>';
                                    echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>';
                                    echo '</div>';
                                    echo '<div class="card-body d-flex flex-column justify-content-end">';
                                    echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                                    echo '<p class="card-text">' . "Rezoliucija: " . $row["rezoliucija"] . '</p>';
                                    echo '<p class="card-text">' . "Vaizdo plokštė: " . $row["lieciamas_ekranas"] . '</p>';
                                    echo '<p class="card-text">' . "Operatyvioji atmintis (ekrano_istrizaine): " . $row["ekrano_istrizaine"] . '</p>';
                                    echo '<p class="card-text">' . "Prekės kodas: MON00" . $row["id"] . '</p>';
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
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
    require_once 'assets/footer.php';
    ?>

    <!-- fancybox -->
    <script>
        $(document).ready(function() {
            $('[data-fancybox="gallery1"]').fancybox({
                loop: true,
                buttons: [
                    "zoom",
                    "slideShow",
                    "fullScreen",
                    "thumbs",
                    "close"
                ]
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
            fetch('nesiojami.php', {
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