<?php
    session_start();

    $email = $_POST["email"];
    $pass = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "PrenotazioniLaMantia");
    $query = "SELECT * FROM clienti WHERE email = \"$email\"";
    $result = mysqli_query($conn, $query);

    if ($result)
    {
        $result = mysqli_fetch_assoc($result);
        if (password_verify($pass, $result["password"]))
        {
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $email;
            $_SESSION["nome"] = $result["nome"];
            echo "REDIRECT, index.php";
            //header("location: ../index.php");
        } else
        {
            echo "Password sbagliata.";
        }
    } else
    {
        echo "Non esiste un account con questa mail! Prova ad inserirne un'altra.";
    }
