<?php
// Povezivanje na MySQL bazu podataka
$db = new SQLite3("forma_db.db");

// Provera konekcije
if (!$db) {
    die("Greška pri povezivanju na bazu: " . $db->error);
}

$query = "CREATE TABLE IF NOT EXISTS my_table (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ime VARCHAR(255),
        prezime VARCHAR(255),
        email VARCHAR(255) CHECK (email LIKE '%@%'),
        poruka TEXT
)";

$db->query($query);

// Prihvatanje podataka iz forme
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$email = $_POST['email'];
$poruka = $_POST['poruka'];

// Upisivanje podataka u sqlite tabelu
$query = "INSERT INTO my_table (ime, prezime, email, poruka) VALUES ('$ime', '$prezime', '$email', '$poruka')";
if ($db->query($query)) {
    echo "Podaci su uspešno sačuvani u bazi.";
} else {
    echo "Greška pri upisu podataka u bazu: " . $db->error;
}

// Čuvanje podataka u JSON fajlu
$data = [
    'ime' => $ime,
    'prezime' => $prezime,
    'email' => $email,
    'poruka' => $poruka
];

$json_data = json_encode($data);

$ime_fajla = strtolower($ime)."_".strtolower($prezime).".json";
file_put_contents($ime_fajla, $json_data);
?>
