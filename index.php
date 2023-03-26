<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once 'components/head.php';
    ?>
</head>

<body>

    <!-- db conn -->
    <?php
    require 'db.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>

    <!-- navbar -->
    <?php
    require_once 'components/nav.php';
    ?>

    <div class="first-container d-flex align-items-center justify-content-end vh-100">
        <div class="second-container">
            <h1 class="fw-bold">Lorem Ipsum</h1>
            <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, <br> consectetur, adipisci velit... There is no one who loves pain itself,<br> who seeks after it and wants to have it, <br> simply because it is pain..."</p>
            <button class="btn btn-black">Plačiau</button>
        </div>
    </div>

    <!-- Kategorijos -->
    <div class="container mt-3 mb-3 custom-container">
        <div class="row row-cols-1 row-cols-md-2 g-3">
            <div class="col-md-5">
                <div class="card h-100 shadow rounded-0" style="background-image: url('assets/img/laptops.jpg'); background-size: cover; border: none;">
                    <div class="card-body" style="height: 350px;">
                        <a href="components/nesiojami.php" class="btn btn-primary-white" style="position:absolute; bottom:20px; left:20px;">Nešiojami Kompiuteriai</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card h-100 shadow rounded-0" style="background-image: url('assets/img/pc.webp'); background-size: cover; border: none;">
                    <div class="card-body" style="height: 350px;">
                        <a href="components/staliniai.php" class="btn btn-primary-white" style="position:absolute; bottom:20px; left:20px;">Staliniai Kompiuteriai</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card h-100 shadow rounded-0" style="background-image: url('assets/img/monitor.webp'); background-size: cover; border: none;">
                    <div class="card-body" style="height: 350px;">
                        <a href="components/monitoriai.php" class="btn btn-primary-white" style="position:absolute; bottom:20px; left:20px;">Monitoriai</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card h-100 shadow rounded-0" style="background-image: url('assets/img/accessories.jpg'); background-size: cover; border: none;">
                    <div class="card-body" style="height: 350px;">
                        <a href="components/priedai.php" class="btn btn-primary-white" style="position:absolute; bottom:20px; left:20px;">Kompiuterių Priedai</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
    require_once 'components/footer.php';
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