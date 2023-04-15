<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
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
            <a class="nav-link" href="../crud/nesiojami_kompiuteriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;" data-offset="80">Nešiojami Kompiuteriai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../crud/staliniai_kompiuteriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Staliniai Kompiuteriai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../crud/monitoriai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Monitoriai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../crud/kompiuteriu_priedai/index.php" style="font-size: 1rem; transition: all 0.3s ease-in-out;">Kompiuterių Priedai</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>