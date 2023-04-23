<?php
// Connect to the database
require '../../db.php';

// Check for errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$pavadinimas = mysqli_real_escape_string($conn, $_POST['pavadinimas']);
$aprasymas = mysqli_real_escape_string($conn, $_POST['aprasymas']);
$kaina = mysqli_real_escape_string($conn, $_POST['kaina']);
$nauja_kaina = mysqli_real_escape_string($conn, $_POST['nauja_kaina']);
$gamintojas = mysqli_real_escape_string($conn, $_POST['gamintojas']);

// Check if a photo was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    // Get file name and path
    $filename = basename($_FILES['photo']['name']);
    $filepath = "uploads/" . $filename;

    // Move file to uploads directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
        // Insert data into table
        // $sql = "INSERT INTO `akcijos` (`pavadinimas`, `aprasymas`, `kaina`, `gamintojas`, `photo`) VALUES ('$pavadinimas', `$gamintojas`, `$aprasymas`, `$kaina`, '$filename')";
        $sql = "INSERT INTO `akcijos` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`, `nauja_kaina`, `photo`) 
        VALUES ('$pavadinimas', '$gamintojas', '$aprasymas', $kaina, '$filename')";
        if (mysqli_query($conn, $sql)) {
            echo "New akcijos added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    // Insert data into table without photo
    // $sql = "INSERT INTO `akcijos` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`) VALUES ('$pavadinimas', `$gamintojas`, '$aprasymas', $kaina)";
    $sql = "INSERT INTO `akcijos` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`, `nauja_kaina`) 
        VALUES ('$pavadinimas', '$gamintojas', '$aprasymas', $kaina, $nauja_kaina)";

    if (mysqli_query($conn, $sql)) {
        $akcijos_id = mysqli_insert_id($conn); // Get the ID of the inserted akcijos
        // Insert photos into `akcijos_photos` table
        foreach ($_FILES['photo']['name'] as $i => $filename) {
            if ($_FILES['photo']['error'][$i] == 0) {
                $filepath = "uploads/" . basename($filename);
                if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $filepath)) {
                    $sql = "INSERT INTO `akcijos_photos` (`akcijos_id`, `filename`) VALUES ($akcijos_id, '$filename')";
                    mysqli_query($conn, $sql);
                    echo "New photo uploaded successfully.";
                } else {
                    echo "Error uploading file: " . $_FILES['photo']['error'][$i];
                }
            }
        }
        echo "New akcijos added successfully.";
        // Redirect back to the akcijos list
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
