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
            <h3 id="kompiuteriu_priedai" class="text-center">Kompiuterių priedai</h3>
            <div class="row justify-content-center">
                <?php
                $sql = "SELECT m.id, m.pavadinimas, m.aprasymas, m.kaina, m.gamintojas, GROUP_CONCAT(mp.filename SEPARATOR ',') AS photos 
    FROM kompiuteriu_priedai m 
    LEFT JOIN kompiuteriu_priedai_photos mp ON m.id = mp.kompiuteriu_priedai_id 
    GROUP BY m.id";
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
                            echo '<img src="../crud/kompiuteriu_priedai/uploads/' . $photo . '" class="card-img-top" alt="product image">';
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
        <!-- footer -->
        <?php
        require_once 'footer.php';
        ?>
    </div>
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