<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

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
$gamintojas = mysqli_real_escape_string($conn, $_POST['gamintojas']);

// Check if a photo was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    // Get file name and path
    $filename = basename($_FILES['photo']['name']);
    $filepath = "uploads/" . $filename;

    // Move file to uploads directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
        // Insert data into table
        // $sql = "INSERT INTO `kompiuteriu_priedai` (`pavadinimas`, `aprasymas`, `kaina`, `gamintojas`, `photo`) VALUES ('$pavadinimas', `$gamintojas`, `$aprasymas`, `$kaina`, '$filename')";
        $sql = "INSERT INTO `kompiuteriu_priedai` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`, `photo`) 
        VALUES ('$pavadinimas', '$gamintojas', '$aprasymas', $kaina, '$filename')";
        if (mysqli_query($conn, $sql)) {
            echo "New kompiuteriu_priedai added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    // Insert data into table without photo
    // $sql = "INSERT INTO `kompiuteriu_priedai` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`) VALUES ('$pavadinimas', `$gamintojas`, '$aprasymas', $kaina)";
    $sql = "INSERT INTO `kompiuteriu_priedai` (`pavadinimas`, `gamintojas`, `aprasymas`, `kaina`) 
        VALUES ('$pavadinimas', '$gamintojas', '$aprasymas', $kaina)";

    if (mysqli_query($conn, $sql)) {
        $kompiuteriu_priedai_id = mysqli_insert_id($conn); // Get the ID of the inserted kompiuteriu_priedai
        // Insert photos into `kompiuteriu_priedai_photos` table
        foreach ($_FILES['photo']['name'] as $i => $filename) {
            if ($_FILES['photo']['error'][$i] == 0) {
                $filepath = "uploads/" . basename($filename);
                if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $filepath)) {
                    $sql = "INSERT INTO `kompiuteriu_priedai_photos` (`kompiuteriu_priedai_id`, `filename`) VALUES ($kompiuteriu_priedai_id, '$filename')";
                    mysqli_query($conn, $sql);
                    echo "New photo uploaded successfully.";
                } else {
                    echo "Error uploading file: " . $_FILES['photo']['error'][$i];
                }
            }
        }
        echo "New kompiuteriu_priedai added successfully.";
        // Redirect back to the kompiuteriu_priedai list
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
