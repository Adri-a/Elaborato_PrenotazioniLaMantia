<?php
session_start();
    $conn = mysqli_connect("localhost", "root", "", "prenotazioniLaMantia");
    $query = "DELETE FROM `prenotazioni` WHERE `cliente` = \"" . $_SESSION["user"]."\" AND `data` = \"" . $_POST["data"]. "\"";
    $result = mysqli_query($conn, $query);

    if ($result)
    {
        echo "OK";
    } else
    {
        echo mysqli_error($conn);
    }
    mysqli_close($conn);
    return;

?>