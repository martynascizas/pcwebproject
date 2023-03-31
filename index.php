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

    <!-- categorys section1 -->
    <?php
    require_once 'components/section1.php';
    ?>

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