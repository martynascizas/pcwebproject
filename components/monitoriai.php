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

    <!-- filtravimas -->
    <div class="col-md-3" style="margin-top: 100px; margin-left: 30px;">
        <h4>Filtruojam</h4>
        <form>
            <div class="mb-3">
                <?php
                // Execute query to retrieve distinct gamintojas values
                $sql = "SELECT DISTINCT gamintojas FROM monitoriai";
                $result = mysqli_query($conn, $sql);
                ?>
                <label for="gamintojas" class="form-label">Gamintojas</label>
                <select class="form-select" id="gamintojas">
                    <option value="">Visi</option>
                    <?php
                    // Loop through result set and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row["gamintojas"] . '">' . $row["gamintojas"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <?php
                // Execute query to retrieve distinct ekrano_istrizaine values
                $sql = "SELECT DISTINCT ekrano_istrizaine FROM monitoriai";
                $result = mysqli_query($conn, $sql);
                ?>
                <label for="ekrano_istrizaine" class="form-label">Įstrižainė</label>
                <select class="form-select" id="ekrano_istrizaine">
                    <option value="">Visi</option>
                    <?php
                    // Loop through result set and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row["ekrano_istrizaine"] . '">' . $row["ekrano_istrizaine"] . '"</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <?php
                // Execute query to retrieve distinct rezoliucija values
                $sql = "SELECT DISTINCT rezoliucija FROM monitoriai";
                $result = mysqli_query($conn, $sql);
                ?>
                <label for="rezoliucija" class="form-label">Ekrano rezoliucija</label>
                <select class="form-select" id="rezoliucija">
                    <option value="">Visi</option>
                    <?php
                    // Loop through result set and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row["rezoliucija"] . '">' . $row["rezoliucija"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="lieciamas_ekranas" class="form-label">Liečiamas ekranas</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="lieciamas_ekranas" id="touchscreen-yes" value="yes">
                    <label class="form-check-label" for="touchscreen-yes">
                        Taip
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="lieciamas_ekranas" id="touchscreen-no" value="no">
                    <label class="form-check-label" for="touchscreen-no">
                        Ne
                    </label>
                </div>
            </div>
            <?php
            // Query the database to get the minimum and maximum values for kaina column
            $sql = "SELECT MIN(kaina) AS min_kaina, MAX(kaina) AS max_kaina FROM monitoriai";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $min_kaina = $row['min_kaina'];
            $max_kaina = $row['max_kaina'];
            ?>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <label for="price1" class="form-label">Kaina nuo:</label>
                    <input type="range" class="form-range" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="10" id="price1" name="price1">
                </div>
                <div>
                    <label for="price2" class="form-label">Kaina iki:</label>
                    <input type="range" class="form-range" min="<?php echo $min_kaina; ?>" max="<?php echo $max_kaina; ?>" step="10" id="price2" name="price2">
                </div>
            </div>
            <div>
                <span id="price-range"><?php echo $min_kaina; ?> - <?php echo $max_kaina; ?></span> Eur
            </div>
            <button type="submit" class="btn btn-primary" name="filter_submit">Filtruoti</button>

        </form>
    </div>


    <div class="wrapper">
        <div class="container products_section mb-5 products-margin">
            <h3 id="monitoriai" class="text-center mb-5">Monitoriai</h3>
            <div class="row justify-content-center">
                <?php
                $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.rezoliucija, .m.lieciamas_ekranas, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
            FROM monitoriai m 
            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
            GROUP BY m.id";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card mb-3 h-100 shadow-sm">';
                        echo '<div id="carouselExampleControls' . $row["id"] . '" class="carousel slide" data-bs-ride="carousel">';
                        echo '<div class="carousel-inner">';
                        $photos = explode(",", $row["photos"]);
                        $active = true;
                        foreach ($photos as $photo) {
                            echo '<div class="carousel-item';
                            if ($active) {
                                echo ' active';
                                $active = false;
                            }
                            echo '">';
                            echo '<img src="../crud/monitoriai/uploads/' . $photo . '" class="d-block w-100" alt="product image">';
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
                        echo '<div class="card-body d-flex flex-column justify-content-between">';
                        echo '<h5 class="card-title">' .
                            $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">Ekrano Įstrižainė: ' .
                            $row["ekrano_istrizaine"] . '"' . '</p>';
                        echo '<p class="card-text">Ekrano Rezoliucija: ' .
                            $row["rezoliucija"] . '</p>';
                        echo '<p class="card-text">Lieciamas ekranas: ' .
                            $row["lieciamas_ekranas"] . '</p>';
                        echo '<p class="card-text">Kaina: ' .
                            $row["kaina"] . ' EUR</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-muted'>monitoriai - nerasta</p>";
                }
                
                // if (mysqli_num_rows($result) > 0) {
                //     while ($row = mysqli_fetch_assoc($result)) {
                //         echo '<div class="col-md-4">';
                //         echo '<div class="card mb-3 h-100 shadow-sm">';
                //         echo '<div class="card-body d-flex flex-column justify-content-between">';
                //         echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                //         echo '<p class="card-text">Ekrano Įstrižainė: ' . $row["ekrano_istrizaine"] . '"' . '</p>';
                //         echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                //         echo '<div class="d-flex align-items-center justify-content-center">';
                //         $photos = explode(",", $row["photos"]);
                //         echo '<div class="d-flex align-items-center justify-content-center">';
                //         foreach ($photos as $photo) {
                //             echo '<img src="../crud/monitoriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                //         }
                //         echo '</div>';
                //         echo '</div>';
                //         echo '</div>';
                //         echo '</div>';
                //         echo '</div>';
                //     }
                // } else {
                //     echo "<p class='text-muted'>monitoriai - nerasta</p>";
                // }
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

    <!-- price -->
    <script>
        const price1 = document.getElementById('price1');
        const price2 = document.getElementById('price2');
        const priceRange = document.getElementById('price-range');

        function updatePriceRange() {
            const minPrice = price1.value;
            const maxPrice = price2.value;
            priceRange.textContent = minPrice + ' - ' + maxPrice;
        }

        price1.addEventListener('input', updatePriceRange);
        price2.addEventListener('input', updatePriceRange);
    </script>
    <!-- Link to Bootstrap JS and jQuery files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>