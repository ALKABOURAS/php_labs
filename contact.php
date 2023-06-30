<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$dbconn = mysqli_connect($servername,
    $username, $password, $dbname);
// Έλεγχος σύνδεσης
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error ());
}
//ορισμός charset της σύνδεσης ώστε να παρουσιάζονται τα ελληνικά σωστά
mysqli_set_charset($dbconn, "utf8");
//Δημιουργία ερωτήματος για την αποθήκευση των στοιχείων στη βάση
if (isset ($_POST['save']) && $_POST['save'] === "Αποθήκευση"){
    // Παίρνουμε τις τιμές των πεδίων της φόρμας στις μεταβλητές με μέθοδο POST
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['street'];
    $phone = $_POST['phone'];
    $tk = $_POST['tk'];
    $country = $_POST['country'];
    $card_type = $_POST['card-type'];
    $card_number = $_POST['card'];

// sql query για την αποθήκευση των στοιχείων στη βάση (πίνακας users)
    $sql = "INSERT INTO users (name, email, tk, phone, card_type, card_number,address, country)
VALUES ('$name','$email','$tk','$phone','$card_type','$card_number','$address','$country')";
// έλεγχος επιτυχίας της εισαγωγής
    if ($dbconn->query($sql) === TRUE) {
        // αν η εγγραφή είναι επιτυχής τότε εμφανίζεται μήνυμα επιτυχίας και γίνεται ανακατεύθυνση στην αρχική σελίδα
        echo '<script>window.location.href = "index.php";
                alert("Επιτυχής Εγγραφή!");
        </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
}
else{ //Δημιουργία ερωτήματος για την αναζήτηση του email στη βάση
    $email = $_GET['searchQuery'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $dbconn->query($sql);
    // τα αποτελέσματα θα εμφανιστούν σε μορφή πίνακα, οπότε δημιουργούμε τις επικεφαλίδες του πίνακα για να
    // τον γεμίσουμε γραμμή προς γραμμή
    $resultsHtml='<tr><th>Όνομα</th><th>Διεύθυνση</th><th>Email</th><th>Χώρα</th><th>Τ.Κ.</th><th>Τηλέφωνο</th><th>Πιστωτική</th><th>Αριθμός</th></tr>';
    // σπάμε τα αποτελέσματα από τη βάση με την mysqli_fetch_array γραμμή προς γραμμή και τα γράφουμε σε μορφή table row
    while($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone'];
        $tk = $row['tk'];
        $country = $row['country'];
        if ($row['card_type'] === 'VS'){
            $card_type = 'Visa';
        }
        elseif ($row['card_type'] === 'MS'){
            $card_type = 'MasterCard';
        }
        else{
            $card_type = 'Άλλο';
        }
        $card_number = $row['card_number'];
        $resultsHtml .='<tr><td>'.$name.'</td><td>'.$address.'</td><td>'.$email.'</td><td>'.$country.'</td><td>'.$tk.'</td><td>'.$phone.'</td><td>'.$card_type.'</td><td>'.$card_number.'</td></tr>';
    }
    // στέλνουμε encoded τα html δεδομένα με μορφή query string στην αρχική σελίδα για να τα εμφανίσουμε
    header('Location: index.php?searchResults='.urlencode($resultsHtml));
}
// close connection
$dbconn->close();
