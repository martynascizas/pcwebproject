<section id="latest-products">
    <div class="wrapper">
        <div class="container products_section products-margin">
            <h3 id="nesiojami_kompiuteriai" class="text-center">Naujausi produktai</h3>
            <div class="row justify-content-center">
                <!--nesiojami-->
                <?php
                $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
                FROM nesiojami_kompiuteriai m 
                LEFT JOIN nesiojami_kompiuteriai_photos mp ON m.id = mp.nesiojami_kompiuteriai_id 
                GROUP BY m.id 
                ORDER BY m.timestamp DESC 
                LIMIT 3";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card mb-3 h-100 shadow-sm">';
                        echo '<div class="card-body d-flex flex-column justify-content-between">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">Ekrano Įstrižainė: ' . $row["ekrano_istrizaine"] . '"</p>';
                        echo '<p class="card-text">Procesorius: ' . $row["procesorius"] . '</p>';
                        echo '<p class="card-text">Vaizdo Plokštė: ' . $row["vaizdo_plokste"] . '</p>';
                        echo '<p class="card-text">Atmintis (RAM): ' . $row["ram"] . '</p>';
                        echo '<p class="card-text">Kietasis diskas (HDD): ' . $row["hdd"] . '</p>';
                        echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        $photos = explode(",", $row["photos"]);
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        foreach ($photos as $photo) {
                            echo '<img src="../pcwebsiteproject/crud/nesiojami_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-muted'>nesiojami_kompiuteriai - nerasta</p>";
                }
                ?>

                <!--staliniai-->
                <?php
                $sql = "SELECT m.id, m.gamintojas, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM staliniai_kompiuteriai m 
    LEFT JOIN staliniai_kompiuteriai_photos mp ON m.id = mp.staliniai_kompiuteriai_id 
    GROUP BY m.id
    ORDER BY m.timestamp DESC 
                LIMIT 3";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-3 h-100 shadow-sm">';
                        echo '<div class="card-body d-flex flex-column justify-content-between">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">Procesorius: ' . $row["procesorius"] . '</p>';
                        echo '<p class="card-text">Vaizdo Plokštė: ' . $row["vaizdo_plokste"] . '</p>';
                        echo '<p class="card-text">Atmintis (RAM): ' . $row["ram"] . '</p>';
                        echo '<p class="card-text">Kietasis diskas (HDD): ' . $row["hdd"] . '</p>';
                        echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        $photos = explode(",", $row["photos"]);
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        foreach ($photos as $photo) {
                            echo '<img src="../pcwebsiteproject/crud/staliniai_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-muted'>staliniai_kompiuteriai - nerasta</p>";
                }
                ?>
                <!--monitoriai-->
                <?php
                $sql = "SELECT m.id, m.gamintojas, m.ekrano_istrizaine, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
            FROM monitoriai m 
            LEFT JOIN monitoriai_photos mp ON m.id = mp.monitoriai_id 
            GROUP BY m.id
            ORDER BY m.timestamp DESC 
                LIMIT 3";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-3 h-100 shadow-sm">';
                        echo '<div class="card-body d-flex flex-column justify-content-between">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">Ekrano Įstrižainė: ' . $row["ekrano_istrizaine"] . '"' . '</p>';
                        echo '<p class="card-text">Prekių Kategorija: ' . 'Monitoriai' . '</p>';
                        echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        $photos = explode(",", $row["photos"]);
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        foreach ($photos as $photo) {
                            echo '<img src="../pcwebsiteproject/crud/monitoriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-muted'>monitoriai - nerasta</p>";
                }
                ?>
                <!--priedai-->
                <?php
                $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.kaina, m.gamintojas, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM kompiuteriu_priedai m 
    LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id 
    GROUP BY m.id
            ORDER BY m.timestamp DESC 
                LIMIT 3";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-3 h-100 shadow-sm">';
                        echo '<div class="card-body d-flex flex-column justify-content-between">';
                        echo '<h5 class="card-title">' . $row["gamintojas"] . '</h5>';
                        echo '<p class="card-text">Pavadinimas: ' . $row["pavadinimas"] . '' . '</p>';
                        echo '<p class="card-text">Aprašymas: ' .  $row["aprasymas"] . '</p>';
                        echo  "Prekių Kategorija: " . " Kompiuterių priedai " . " </p>";
                        echo '<p class="card-text">Kaina: ' . $row["kaina"] . ' EUR</p>';
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        $photos = explode(",", $row["photos"]);
                        echo '<div class="d-flex align-items-center justify-content-center">';
                        foreach ($photos as $photo) {
                            echo '<img src="../pcwebsiteproject/crud/kompiuteriu_priedai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-muted'>Kompiuterių priedai - nerasta</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>