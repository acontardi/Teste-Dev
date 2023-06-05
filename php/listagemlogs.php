<?php
    // Conecta ao banco de dados
    $conn = mysqli_connect("localhost", "seu_usuario", "sua_senha", "seu_banco_de_dados");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn === false) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    // Função para registrar um log de alteração
    function logAlteracao($userId, $action) {
        global $conn;
        $timestamp = date('Y-m-d H:i:s');
        $query = "INSERT INTO logs (user_id, action, timestamp) VALUES ('$userId', '$action', '$timestamp')";
        mysqli_query($conn, $query);
    }

    // Exemplo de uso
    $userId = 1; // ID do usuário que realizou a alteração
    $action = "Usuário atualizou as configurações do sistema.";
    logAlteracao($userId, $action);

    // Consulta os registros de logs
    $query = "SELECT * FROM logs ORDER BY timestamp DESC";
    $result = mysqli_query($conn, $query);

    // Exibe os registros na página
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Usuário ID: " . $row['user_id'] . "<br>";
        echo "Ação: " . $row['action'] . "<br>";
        echo "Data e Hora: " . $row['timestamp'] . "<br><br>";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
?>