<?php
// Função para verificar a autenticação do usuário
function autenticar($username, $password) {

    // Retorna verdadeiro se as credenciais estiverem corretas, falso caso contrário
    return ($username === 'usuario' && $password === 'senha');
}

// Verifica se as credenciais de autenticação foram fornecidas
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    // Verifica a autenticação
    if (autenticar($username, $password)) {
        // Autenticação bem-sucedida

        // Exemplo de registros de sistema
        $registros = [
            [
                "id" => 1,
                "nome" => "Registro 1",
                "descricao" => "Descrição do registro 1"
            ],
            [
                "id" => 2,
                "nome" => "Registro 2",
                "descricao" => "Descrição do registro 2"
            ],
            [
                "id" => 3,
                "nome" => "Registro 3",
                "descricao" => "Descrição do registro 3"
            ]
        ];

        // Define o cabeçalho para indicar que o retorno será em formato JSON
        header('Content-Type: application/json');

        // Converte o array de registros em formato JSON
        $json = json_encode($registros);

        // Imprime o JSON como resposta do Web Service
        echo $json;
        exit();
    }
}

// Se as credenciais não forem fornecidas ou a autenticação falhar, exibe uma mensagem de erro
header('WWW-Authenticate: Basic realm="Acesso restrito"');
header('HTTP/1.0 401 Unauthorized');
echo 'Acesso não autorizado.';
exit();
?>