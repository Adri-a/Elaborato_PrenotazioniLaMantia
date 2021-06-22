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
if ($ora == "--:--")
{
    echo "Seleziona un orario!";
    return;
}
if ($servizio == "Seleziona un servizio")
{
    echo "Seleziona un servizio!";
    return;
}
$conn = mysqli_connect("localhost", "root", "", "prenotazioniLaMantia");
//Controllo che utente non abbia già effettuato una prenotazione per il giorno
$query_check_giorno = "SELECT * FROM prenotazioni WHERE cliente = \"" . $_SESSION["user"] . "\" AND DATE(`data`) = \"" . $data . "\"";
$result_check_giorno = mysqli_query($conn, $query_check_giorno);

if ($result_check_giorno) {
    if (mysqli_num_rows($result_check_giorno) != 0) {
        echo "Hai già prenotato per questo giorno! Ricordati che puoi prenotare solo una volta. Contattaci per ulteriori informazioni.";
        return;
    }

    //Controllo che uno chef sia disponibile
    $query_chef_disponibili = "SELECT DISTINCT turni.chef
    FROM turni, chef
    WHERE chef.ristorante = \"$ristorante\" AND turni.chef = chef.id_chef AND turni.giorno = \"$data\"
     AND turni.chef not in (SELECT prenotazioni.chef FROM prenotazioni WHERE date(`prenotazioni`.`data`) = \"$data\")";
    $result_chef = mysqli_query($conn, $query_chef_disponibili);

    if ($result_chef) {
        if (mysqli_num_rows($result_chef) > 0) {
            //Assegnazione del primo chef disponibile alla prenotazione
            $chef_assegnato = mysqli_fetch_row($result_chef);
            if ($note == "") {
                $query = "INSERT INTO `prenotazioni`(`cliente`, `data`, `chef`, `servizio`, `n_persone`, `via`, `n_civico`, `citta`, `provincia`, `note`)
            VALUES (\"" . $_SESSION["user"] . "\", \"$data $ora\",\"" . $chef_assegnato[0] . "\",\"$servizio\",$persone,\"" . $indirizzo[0] . "\",
            \"" . $indirizzo[1] . "\",\"" . $indirizzo[2] . "\",\"" . $indirizzo[3] . "\", null)";
            }
            $query = "INSERT INTO `prenotazioni`(`cliente`, `data`, `chef`, `servizio`, `n_persone`, `via`, `n_civico`, `citta`, `provincia`, `note`)
            VALUES (\"" . $_SESSION["user"] . "\", \"$data $ora\",\"" . $chef_assegnato[0] . "\",\"$servizio\",$persone,\"" . $indirizzo[0] . "\",
            \"" . $indirizzo[1] . "\",\"" . $indirizzo[2] . "\",\"" . $indirizzo[3] . "\",\"$note\")";

            $result = mysqli_query($conn, $query);
            if ($result) {
                //Ottengo prezzo di servizio prenotato
                $query_prezzo = "SELECT prezzo FROM servizi WHERE nome = \"$servizio\"";
                $result_prezzo = mysqli_query($conn, $query_prezzo);

                if ($result_prezzo) {
                    $prezzo = mysqli_fetch_assoc($result_prezzo)["prezzo"];
                    //restituisce un JSON
                    echo '{"risultato": "OK", "telefono": "' . $telefono . '", "data": "' . $data . ' ' . $ora . '", "servizio": "' . $servizio . '", "persone": "' . $persone . '", "indirizzo": "' . $indirizzo[0] . ' ' . $indirizzo[1] . ', ' . $indirizzo[2] . ' (' . $indirizzo[3] . ')", "prezzo": "' . $prezzo . '", "note": "' . $note . '"}';
                    return;
                }
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
} else {
    echo mysqli_error($conn);
    return;
}

mysqli_close($conn);
