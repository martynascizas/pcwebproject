<?php
require_once 'components/head.php';
?>

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
?>

<body>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-transparent">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php" style="font-size: 2rem; transition: all 0.3s ease-in-out;">LOGO</a>
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto" style="transition: all 0.3s ease-in-out;">
          <li class="nav-item">
            <a class="nav-link" href="../admin/nesiojami_kompiuteriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;" data-offset="80">Nešiojami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../admin/staliniai_kompiuteriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Staliniai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../admin/monitoriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Monitoriai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../admin/kompiuteriu_priedai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Priedai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html> -->