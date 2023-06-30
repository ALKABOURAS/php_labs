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
//Δημιουργία ερωτήματος
if (isset ($_POST['save']) && $_POST['save'] === "Αποθήκευση"){
    // get values from post request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['street'];
    $phone = $_POST['phone'];
    $tk = $_POST['tk'];
    $country = $_POST['country'];
    $card_type = $_POST['card-type'];
    $card_number = $_POST['card'];

// sql query to insert into table users
    $sql = "INSERT INTO users (name, email, tk, phone, card_type, card_number,address, country)
VALUES ('$name','$email','$tk','$phone','$card_type','$card_number','$address','$country')";
// check if query is successful
    if ($dbconn->query($sql) === TRUE) {
        // redirect to index with success message on alert
        echo '<script>window.location.href = "index.php";
                alert("Επιτυχής Εγγραφή!");
        </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
}
else{
    $email = $_GET['searchQuery'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $dbconn->query($sql);
    $resultsHtml='<tr><th>Όνομα</th><th>Διεύθυνση</th><th>Email</th><th>Χώρα</th><th>Τ.Κ.</th><th>Τηλέφωνο</th><th>Πιστωτική</th><th>Αριθμός</th></tr>';
// Εμφάνιση αποτελεσμάτων στις γραμμές του πίνακα
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
header('Location: index.php?searchResults='.urlencode($resultsHtml));
}
// close connection
$dbconn->close();
