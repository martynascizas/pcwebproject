<?php
// Connect to the database
require '../../db.php';

// Check for errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$gamintojas = mysqli_real_escape_string($conn, $_POST['gamintojas']);
$ekrano_istrizaine = mysqli_real_escape_string($conn, $_POST['ekrano_istrizaine']);
$kaina = mysqli_real_escape_string($conn, $_POST['kaina']);
$lieciamas_ekranas = mysqli_real_escape_string($conn, $_POST['touchscreen']);
$rezoliucija = mysqli_real_escape_string($conn, $_POST['rezoliucija']);

// Check if a photo was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    // Get file name and path
    $filename = basename($_FILES['photo']['name']);
    $filepath = "uploads/" . $filename;

    // Move file to uploads directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
        // Insert data into table
        $sql = "INSERT INTO `monitoriai` (`gamintojas`, `ekrano_istrizaine`, `lieciamas_ekranas`. `rezoliucija`, `kaina`, `photo`) VALUES ('$gamintojas', $ekrano_istrizaine, $lieciamas_ekranas, $kaina, '$filename')";
        if (mysqli_query($conn, $sql)) {
            echo "New monitor added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    // Insert data into table without photo
    $sql = "INSERT INTO `monitoriai` (`gamintojas`, `ekrano_istrizaine`, `lieciamas_ekranas`, `rezoliucija`, `kaina`) 
    VALUES ('$gamintojas', $ekrano_istrizaine, '$lieciamas_ekranas', '$rezoliucija', $kaina)";


    if (mysqli_query($conn, $sql)) {
        $monitor_id = mysqli_insert_id($conn); // Get the ID of the inserted monitor
        // Insert photos into `monitoriai_photos` table
        foreach ($_FILES['photo']['name'] as $i => $filename) {
            if ($_FILES['photo']['error'][$i] == 0) {
                $filepath = "uploads/" . basename($filename);
                if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $filepath)) {
                    $sql = "INSERT INTO `monitoriai_photos` (`monitoriai_id`, `filename`) VALUES ($monitor_id, '$filename')";
                    mysqli_query($conn, $sql);
                    echo "New photo uploaded successfully.";
                } else {
                    echo "Error uploading file: " . $_FILES['photo']['error'][$i];
                }
            }
        }
        echo "New monitor added successfully.";
        // Redirect back to the monitoriai list
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
