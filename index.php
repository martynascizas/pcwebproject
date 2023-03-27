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
        <div class="second-container text-black">
            <h1 class="fw-bold mt-5">Lorem Ipsum</h1>
            <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, <br> consectetur, adipisci velit... There is no one who loves pain itself,<br> who seeks after it and wants to have it, <br> simply because it is pain..."</p>
            <a href="#categorys-container" class="btn btn-black">Plačiau</a>
        </div>
    </div>

    <!-- Kategorijos -->
    <div>
        <?php
        require_once 'components/categorys.php';
        ?>
    </div>


    <!-- Btn arrow -->
    <button onclick="scrollToTop()" id="scrollToTopBtn" class="scroll-to-top-btn">&#9650;</button>

    <!-- footer -->
    <div>
        <?php
        require_once 'components/footer.php';
        ?>
    </div>

    <!-- close db conn -->
    <?php
    mysqli_close($conn);
    ?>
    <script>
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            var scrollToTopBtn = document.getElementById("scrollToTopBtn");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        }

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <!-- Link to Bootstrap JS and jQuery files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>