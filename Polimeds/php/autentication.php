<?php
    include 'db_connnection.php';
    
    function autentication() {
        //verifica se há usuario ativo valido
        
        session_start();
        $user_email = $_SESSION["user_email"];
        $user_senha = $_SESSION["user_senha"];
        $compare = "";

        $conn = OpenCon();
        $sql = "SELECT email FROM cliente WHERE email='".$user_email."'";
        $compare = $conn->query($sql)->fetch_assoc()['email'];

        if ($user_email == "") {
            header("Location: ../htmls/error.html");
            $conn->close();
            session_unset();
            session_destroy();
            exit();

        } elseif ($user_email==$compare) {
            $sql = "SELECT senha FROM cliente WHERE email='".$user_email."'";
            $compare = $conn->query($sql)->fetch_assoc()['senha'];

            if ($user_senha!=$compare) {
                header("Location: ../htmls/error.html");
                $conn->close();
                session_unset();
                session_destroy();
                exit();
            }

        } else {
            header("Location: ../htmls/error.html");
            $conn->close();
            session_unset();
            session_destroy();
            exit();
        }

    }
    
?>