<?php
    // Verifica se o formulário de login foi submetido
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtenha os valores dos campos do formulário
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verifique se as credenciais são válidas (exemplo simples)
        if($username == "usuario" && $password == "senha") {
            echo "Login bem-sucedido!";
        } else {
            echo "Nome de usuário ou senha inválidos!";
        }
    }

    // Verifica se o formulário de login foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtenha o endereço IP do usuário
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        // Consulta a tabela de falhas de login para o endereço IP atual
        $query = "SELECT * FROM failed_logins WHERE ip_address = '$ipAddress'";
        $result = mysqli_query($conn, $query);

        // Verifica se houve tentativas de login anteriores para o endereço IP
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $attempts = $row['attempts'];
            $lastAttempt = $row['last_attempt'];

            // Verifica se o período de espera já expirou
            $waitPeriod = 300; // 5 minutos em segundos
            $currentTime = time();

            if (($currentTime - $lastAttempt) < $waitPeriod) {
                echo "Acesso bloqueado. Tente novamente mais tarde.";
                exit();
            }

            // Reseta as tentativas se o último login foi há mais de 5 minutos
            if (($currentTime - $lastAttempt) >= $waitPeriod) {
                $query = "UPDATE failed_logins SET attempts = 0, last_attempt = '$currentTime' WHERE ip_address = '$ipAddress'";
                mysqli_query($conn, $query);
                $attempts = 0;
            }
        } else {
            // Insere um novo registro para o endereço IP se não houver tentativas anteriores
            $currentTime = time();
            $query = "INSERT INTO failed_logins (ip_address, attempts, last_attempt) VALUES ('$ipAddress', 0, '$currentTime')";
            mysqli_query($conn, $query);
            $attempts = 0;
        }

        // Verifica as credenciais de login
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username == "usuario" && $password == "senha") {
            // Login bem-sucedido, então reseta as tentativas e redireciona para a página inicial
            $query = "UPDATE failed_logins SET attempts = 0, last_attempt = '$currentTime' WHERE ip_address = '$ipAddress'";
            mysqli_query($conn, $query);
            header("Location: index.html");
        } else {
            // Incrementa o número de tentativas e atualiza a tabela
            $attempts++;
            $query = "UPDATE failed_logins SET attempts = $attempts, last_attempt = '$currentTime' WHERE ip_address = '$ipAddress'";
            mysqli_query($conn, $query);

            if ($attempts >= 3) {
                echo "Acesso bloqueado. Tente novamente mais tarde.";
                exit();
            }

            echo "Nome de usuário ou senha inválidos!";
        }
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
?>