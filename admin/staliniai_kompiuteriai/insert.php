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
$gamintojas = mysqli_real_escape_string($conn, $_POST['gamintojas']);
$procesorius = mysqli_real_escape_string($conn, $_POST['procesorius']);
$vaizdo_plokste = mysqli_real_escape_string($conn, $_POST['vaizdo_plokste']);
$ram = mysqli_real_escape_string($conn, $_POST['ram']);
$hdd = mysqli_real_escape_string($conn, $_POST['hdd']);
$kaina = mysqli_real_escape_string($conn, $_POST['kaina']);
$filename = '';

// Check if a photo was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    // Get file name and path
    $filename = basename($_FILES['photo']['name']);
    $filepath = "uploads/" . $filename;

    // Move file to uploads directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
        // Insert data into table
        $sql = "INSERT INTO `staliniai_kompiuteriai` (`gamintojas`, `procesorius`, `vaizdo_plokste`, `ram`, `hdd`, `kaina`, `photo`) VALUES ('$gamintojas', '$procesorius', '$vaizdo_plokste', '$ram', '$hdd', '$kaina', '$filename')";
        if (mysqli_query($conn, $sql)) {
            echo "New staliniai_kompiuteriai added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    // Insert data into table without photo
    $sql = "INSERT INTO `staliniai_kompiuteriai` (`gamintojas`, `procesorius`, `vaizdo_plokste`, `ram`, `hdd`, `kaina`, `photo`) VALUES ('$gamintojas', '$procesorius', '$vaizdo_plokste', '$ram', '$hdd', '$kaina', '$filename')";
    if (mysqli_query($conn, $sql)) {
        $staliniai_kompiuteriai_id = mysqli_insert_id($conn); // Get the ID of the inserted staliniai_kompiuteriai
        // Insert photos into `staliniai_kompiuteriai_photos` table
        foreach ($_FILES['photo']['name'] as $i => $filename) {
            if ($_FILES['photo']['error'][$i] == 0) {
                $filepath = "uploads/" . basename($filename);
                if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $filepath)) {
                    $sql = "INSERT INTO `staliniai_kompiuteriai_photos` (`staliniai_kompiuteriai_id`, `filename`) VALUES ($staliniai_kompiuteriai_id, '$filename')";
                    mysqli_query($conn, $sql);
                    echo "New photo uploaded successfully.";
                } else {
                    echo "Error uploading file: " . $_FILES['photo']['error'][$i];
                }
            }
        }
        echo "New item to staliniai_kompiuteriai added successfully.";
        // Redirect back to the staliniai_kompiuteriai list
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
