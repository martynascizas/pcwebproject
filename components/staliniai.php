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

    <div class="container products_section mb-5">
    <h3 id="staliniai_kompiuteriai" class="text-center mt-5">Staliniai Kompiuteriai</h3>
        <div class="row justify-content-center mb-5">
            <?php
            $sql = "SELECT m.id, m.gamintojas, m.procesorius, m.vaizdo_plokste, m.ram, m.hdd, m.kaina, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM staliniai_kompiuteriai m 
    LEFT JOIN staliniai_kompiuteriai_photos mp ON m.id = mp.staliniai_kompiuteriai_id 
    GROUP BY m.id";
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
                        echo '<img src="../crud/staliniai_kompiuteriai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
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
        </div>
    </div>
    <!-- footer -->
    <?php
    require_once 'footer.php';
    ?>

    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>

    <!-- Link to Bootstrap JS and jQuery files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>