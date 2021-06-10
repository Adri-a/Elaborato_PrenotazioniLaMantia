<?php

    $nome = $_POST["name"];
    $cognome  = $_POST["surname"];
    $data_nascita = $_POST["birthdate"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $conf_pass = $_POST["confermaPassword"];

    if ($pass != $conf_pass)
    {
        echo "Le password non corrispondono!";
    } else
    {
        //hashing password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        //connessione + inserimento in db
        $conn = mysqli_connect("localhost", "root", "", "PrenotazioniLaMantia");
        $query = "INSERT INTO `clienti`(`email`, `data_n`, `nome`, `cognome`, `password`)
                  VALUES (\"$email\",\"$data_nascita\",\"$nome\",\"$cognome\",\"$hashed_pass\")";

        $result = mysqli_query($conn, $query);

        if ($result)
        {
            echo "Aggiunto al db";
        } else
        {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>