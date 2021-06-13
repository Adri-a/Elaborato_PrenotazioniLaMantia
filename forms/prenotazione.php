<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    //header("location: ../login.php");
    echo "Prima di prenotare devi effettuare il login o registrarti!";
    return;
}

$telefono = $_POST["phone"];
$data = $_POST["date"];
$ora = $_POST["time"];
$persone = $_POST["people"];
$servizio = $_POST["service"];
$note = $_POST["notes"];
$indirizzo = [$_POST["address"], $_POST["number"], $_POST["city"], $_POST["province"]];

$ristorante = "0270005309";

//Controllo che uno chef sia disponibile
$conn = mysqli_connect("localhost", "root", "", "prenotazioniLaMantia");
$query_chef_disponibili = "SELECT DISTINCT turni.chef
    FROM turni, chef
    WHERE chef.ristorante = \"$ristorante\" AND turni.chef = chef.id_chef AND turni.giorno = \"$data\"
     AND turni.chef not in (SELECT prenotazioni.chef FROM prenotazioni WHERE date(`prenotazioni`.`data`) = \"$data\")";
$result_chef = mysqli_query($conn, $query_chef_disponibili);

if ($result_chef) {
    if (mysqli_num_rows($result_chef) > 0) {
        //Assegnazione del primo chef disponibile alla prenotazione
        $chef_assegnato = mysqli_fetch_row($result_chef);
        if($note == "")
        {
            $query = "INSERT INTO `prenotazioni`(`cliente`, `data`, `chef`, `servizio`, `n_persone`, `via`, `n_civico`, `citta`, `provincia`, `note`)
            VALUES (\"" . $_SESSION["user"] . "\", \"$data $ora\",\"" . $chef_assegnato[0] . "\",\"$servizio\",$persone,\"" . $indirizzo[0] . "\",
            \"" . $indirizzo[1] . "\",\"" . $indirizzo[2] . "\",\"" . $indirizzo[3] . "\", null)";

        }
        $query = "INSERT INTO `prenotazioni`(`cliente`, `data`, `chef`, `servizio`, `n_persone`, `via`, `n_civico`, `citta`, `provincia`, `note`)
            VALUES (\"" . $_SESSION["user"] . "\", \"$data $ora\",\"" . $chef_assegnato[0] . "\",\"$servizio\",$persone,\"" . $indirizzo[0] . "\",
            \"" . $indirizzo[1] . "\",\"" . $indirizzo[2] . "\",\"" . $indirizzo[3] . "\",\"$note\")";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "OK";
            return;
        } else {
            echo mysqli_error($conn);
        }
    } else {
        echo "Non c'è disponibilità per la tua zona! Prova a scegliere un altro giorno.";
        return;
    }
} else {
    echo mysqli_error($conn);
}
