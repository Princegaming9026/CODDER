<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredKey = $_POST['user_key'];
    $secureKey = "BERLIN1";  // Hardcoded key (better to store in environment variables)

    if ($enteredKey === $secureKey) {
        header("Location: success.php");
        exit();
    } else {
        echo "<script>alert('Invalid Key!'); window.location.href='index.html';</script>";
    }
}
?>
