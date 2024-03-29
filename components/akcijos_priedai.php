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

    <div id="offcanvas" class="offcanvas offcanvas-start w-25 p-3" tabindex="-1" id="offcanvas" data-bs-keyboard="false"
        data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title d-none d-sm-block" id="offcanvas">Filtrai</h6>
            <button id="clodeBtn" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <?php
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Construct SQL query with the selected gamintojas value
        $sql = "SELECT m.id, m.gamintojas, m.pavadinimas, m.aprasymas, m.papildoma_informacija, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') 
                    AS photos
                    FROM akcijos_kompiuteriu_priedai m 
                    LEFT JOIN akcijos_kompiuteriu_priedai_photos mp ON m.id = mp.akcijos_kompiuteriu_priedai_id";
        if (!empty($gamintojas) || !empty($pavadinimas) || !empty($aprasymas) || !empty($kaina)) {
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
                            $pavadinimas = $_POST['pavadinimas'];
                            $aprasymas = $_POST['aprasymas'];
                            if (!empty($pavadinimas) || !empty($aprasymas))
                                $sql = "SELECT gamintojas, COUNT(*) AS total 
                                        FROM akcijos_kompiuteriu_priedai 
                                        WHERE  pavadinimas = '$pavadinimas' || aprasymas = '$aprasymas'
                                        GROUP BY gamintojas 
                                        ORDER BY gamintojas ASC";
                            else {
                                $sql = "SELECT gamintojas, COUNT(*) AS total FROM akcijos_kompiuteriu_priedai GROUP BY gamintojas ORDER BY gamintojas ASC";
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
                        <!--Generate select options for pavadinimas-->
                        <label for="pavadinimas" class="form-label">Pavadinimas</label>
                        <select class="form-select" id="pavadinimas" name="pavadinimas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results       
                            $selected_gamintojas = $_POST['gamintojas'];
                            $aprasymas = $_POST['aprasymas'];
                            if (!empty($selected_gamintojas) || !empty($aprasymas))
                                $sql = "SELECT pavadinimas, COUNT(*) AS total 
                                        FROM akcijos_kompiuteriu_priedai 
                                        WHERE gamintojas = '$selected_gamintojas' || aprasymas = '$aprasymas'
                                        GROUP BY pavadinimas 
                                        ORDER BY pavadinimas ASC";
                            else {
                                $sql = "SELECT pavadinimas, COUNT(*) AS total FROM akcijos_kompiuteriu_priedai GROUP BY pavadinimas ORDER BY pavadinimas ASC";
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
                    </li>
                    <li>
                        <!--Generate select options for aprasymas-->
                        <label for="aprasymas" class="form-label">Aprašymas</label>
                        <select class="form-select" id="aprasymas" name="aprasymas">
                            <option value="">Visi</option>
                            <?php
                            // Execute query and fetch results
                            $selected_gamintojas = $_POST['gamintojas'];
                            $pavadinimas = $_POST['pavadinimas'];
                            if (!empty($selected_gamintojas) || !empty($pavadinimas))
                                $sql = "SELECT aprasymas, COUNT(*) AS total 
                                        FROM akcijos_kompiuteriu_priedai 
                                        WHERE gamintojas = '$selected_gamintojas' ||  pavadinimas = '$pavadinimas'
                                        GROUP BY aprasymas 
                                        ORDER BY aprasymas ASC";
                            else {
                                $sql = "SELECT aprasymas, COUNT(*) AS total FROM akcijos_kompiuteriu_priedai GROUP BY aprasymas ORDER BY aprasymas ASC";
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
                    </li>
                    <li>
                        <!--Generate select options for kaina-->
                        <div class="form-group">
                            <?php
                            // Get the minimum and maximum kaina values from the database
                            $sql = "SELECT MIN(nauja_kaina) AS min_kaina, MAX(nauja_kaina) AS max_kaina FROM akcijos_kompiuteriu_priedai";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $min_kaina = $row['min_kaina'];
                            $max_kaina = $row['max_kaina'];

                            ?>
                            <label for="kaina" class="form-label">Kaina nuo: <span id="kaina_nuo_value">
                                    <?php echo isset($_POST['kaina_nuo']) ? $_POST['kaina_nuo'] : $min_kaina; ?>
                                </span></label>
                            <input type="range" class="form-range" id="kaina_nuo" name="kaina_nuo"
                                min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1"
                                value="<?php echo isset($_POST['kaina_nuo']) ? $_POST['kaina_nuo'] : $min_kaina; ?>">

                            <label for="kaina" class="form-label">Kaina iki: <span id="kaina_iki_value">
                                    <?php echo isset($_POST['kaina_iki']) ? $_POST['kaina_iki'] : $max_kaina; ?>
                                </span></label>
                            <input type="range" class="form-range" id="kaina_iki" name="kaina_iki"
                                min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="1"
                                value="<?php echo isset($_POST['kaina_iki']) ? $_POST['kaina_iki'] : $max_kaina; ?>">
                        </div>
                    </li>
                    <li>
                        <div style="display: block; text-align: center;">
                            <button id="clear_btn" type="button" class="btn btn-secondary mb-2">Išvalyti</button>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                            <button id="submit_btn" type="submit" class="btn btn-primary mb-4 d-none"
                                name="filter_submit">Filtruoti</button>
                            <button id="atgal_btn" type="button" class="btn btn-success mb-4">Grįžti</button>
                        </div>
                            <script>
                                document.getElementById("clear_btn").addEventListener("click", function () {
                                    document.getElementById("gamintojas").value = "";
                                    document.getElementById("pavadinimas").value = "";
                                    document.getElementById("aprasymas").value = "";
                                    document.getElementById("kaina_nuo").value = <?php echo $min_kaina; ?>;
                                    document.getElementById("kaina_iki").value = <?php echo $max_kaina; ?>;
                                    document.getElementById("submit_btn").click();
                                });
                                document.getElementById("atgal_btn").addEventListener("click", function() {
                            window.location.href = 'http://localhost/devetas.lt/components/priedai.php';
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
                <button id="sid" class="btn sidebar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
                    role="button">
                    <i class="bi bi-filter fs-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
                </button>
                <div class="wrapper">
                    <div class="container products_section products-margin">
                        <h3 id="akcijos_kompiuteriu_priedai" class="text-center mb-5">Kompiuterių priedai - Akcijos</h3>
                        <?php
                        // Check if form has been submitted
                        if (!isset($_POST['filter_submit'])) {
                            // Perform the JOIN between the tables
                            $sql = "SELECT nk.*, GROUP_CONCAT(nkp.filename) AS photos
                FROM akcijos_kompiuteriu_priedai nk
                LEFT JOIN akcijos_kompiuteriu_priedai_photos nkp ON nk.id = nkp.akcijos_kompiuteriu_priedai_id
                GROUP BY nk.id
                ORDER BY nk.timestamp DESC";

                            $result = mysqli_query($conn, $sql);
                            // Generate the HTML markup for the products
                            echo '<div class="row row-cols-1 row-cols-md-5 g-4">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $photos = explode(",", $row["photos"]);
                                $carousel_items = '';
                                foreach ($photos as $i => $photo) {
                                    $active_class = ($i == 0) ? 'active' : '';
                                    $carousel_items .= '<div class="carousel-item ' . $active_class . '">';
                                    $carousel_items .= '<div><a data-fancybox="gallery" href="../admin/akcijos_kompiuteriu_priedai/uploads/' . $photo . '"><img src="../admin/akcijos_kompiuteriu_priedai/uploads/' . $photo . '" class="d-block w-100 zoomable carousel-image" alt="Product Image"></a></div>';
                                    $carousel_items .= '</div>';
                                }

                                echo '<div class="col">';
                                echo '<div class="card h-100">';
                                echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                                echo '<div class="carousel-inner">' . $carousel_items . '</div>';
                                echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>';
                                echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>';
                                echo '</div>';
                                echo '<div class="card-body card-body-custom d-flex flex-column justify-content-end">';
                                echo '<h5 class="card-title">' . "<b>" . $row["gamintojas"] . "</b>" . '</h5>';
                                echo '<p class="card-text card-text-custom">' . "Pavadinimas: <b>" . $row["pavadinimas"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Aprašymas: <b>" . $row["aprasymas"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Papildoma informacija: <b>" . $row["papildoma_informacija"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Prekės kodas: <b>PRI00" . $row["id"] . '</b></p>';
                                echo '</div>';
                                echo '<div class="card-footer">';
                                echo '<p class="card-text"><span style="text-decoration: line-through;">' . $row["kaina"] . '</span> <span>' . $row["nauja_kaina"] . '</span> Eur</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else if (isset($_POST['filter_submit'])) {
                            // Get the selected gamintojas ... values from the form
                            $gamintojas = $_POST['gamintojas'];
                            $pavadinimas = $_POST['pavadinimas'];
                            $aprasymas = $_POST['aprasymas'];
                            if (isset($_POST['kaina_nuo'])) {
                                $min_kaina = $_POST['kaina_nuo'];
                            }
                            if (isset($_POST['kaina_iki'])) {
                                $max_kaina = $_POST['kaina_iki'];
                            }

                            $sql = "SELECT m.id, m.gamintojas, m.pavadinimas, m.aprasymas, m.papildoma_informacija, m.kaina, m.nauja_kaina, m.timestamp, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos
                FROM akcijos_kompiuteriu_priedai m 
                LEFT JOIN akcijos_kompiuteriu_priedai_photos mp ON m.id = mp.akcijos_kompiuteriu_priedai_id";

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

                            if (!empty($papildoma_informacija)) {
                                $where_conditions[] = "papildoma_informacija = '$papildoma_informacija'";
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
                                echo '<div class="row row-cols-1 row-cols-md-5 g-4">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $photos = explode(",", $row["photos"]);
                                $carousel_items = '';
                                foreach ($photos as $i => $photo) {
                                    $active_class = ($i == 0) ? 'active' : '';
                                    $carousel_items .= '<div class="carousel-item ' . $active_class . '">';
                                    $carousel_items .= '<div><a data-fancybox="gallery" href="../admin/akcijos_kompiuteriu_priedai/uploads/' . $photo . '"><img src="../admin/akcijos_kompiuteriu_priedai/uploads/' . $photo . '" class="d-block w-100 zoomable carousel-image" alt="Product Image"></a></div>';
                                    $carousel_items .= '</div>';
                                }

                                echo '<div class="col">';
                                echo '<div class="card h-100">';
                                echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                                echo '<div class="carousel-inner">' . $carousel_items . '</div>';
                                echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>';
                                echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row["id"] . '" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>';
                                echo '</div>';
                                echo '<div class="card-body card-body-custom d-flex flex-column justify-content-end">';
                                echo '<h5 class="card-title">' . "<b>" . $row["gamintojas"] . "</b>" . '</h5>';
                                echo '<p class="card-text card-text-custom">' . "Pavadinimas: <b>" . $row["pavadinimas"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Aprašymas: <b>" . $row["aprasymas"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Papildoma informacija: <b>" . $row["papildoma_informacija"] . '</b></p>';
                                echo '<p class="card-text card-text-custom">' . "Prekės kodas: <b>PRI00" . $row["id"] . '</b></p>';
                                echo '</div>';
                                echo '<div class="card-footer">';
                                echo '<p class="card-text"><span style="text-decoration: line-through;">' . $row["kaina"] . '</span> <span>' . $row["nauja_kaina"] . '</span> Eur</p>';
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

    <!-- fancybox -->
    <script>
        $(document).ready(function () {
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gamintojasSelect = document.getElementById('gamintojas');
            const pavadinimasSelect = document.getElementById('pavadinimas');
            const aprasymasSelect = document.getElementById('aprasymas');
            const submitBtn = document.getElementById('submit_btn');
            const kainaNuoInput = document.getElementById('kaina_nuo');
            const kainaIkiInput = document.getElementById('kaina_iki');
            let timeoutId;

            gamintojasSelect.addEventListener('change', function () {
                submitBtn.click();
            });

            pavadinimasSelect.addEventListener('change', function () {
                submitBtn.click();
            });

            aprasymasSelect.addEventListener('change', function () {
                submitBtn.click();
            });

            kainaNuoInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    submitBtn.click();
                }, 500); // Wait for 500ms before submitting the form
            });

            kainaIkiInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    submitBtn.click();
                }, 500); // Wait for 500ms before submitting the form
            });
        });
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
        kainaNuo.addEventListener('input', function () {
            if (parseInt(kainaNuo.value) > parseInt(kainaIki.value)) {
                kainaNuo.value = kainaIki.value;
            }
            kainaNuoValue.textContent = kainaNuo.value;
        });
        kainaIki.addEventListener('input', function () {
            if (parseInt(kainaIki.value) < parseInt(kainaNuo.value)) {
                kainaIki.value = kainaNuo.value;
            }
            kainaIkiValue.textContent = kainaIki.value;
        });
    </script>

<style>
    button {
        width: 80px;
    }
    </style>
</body>

</html>