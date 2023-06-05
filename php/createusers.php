<?php
    // Conecta ao banco de dados
    $conn = mysqli_connect("localhost", "seu_usuario", "sua_senha", "seu_banco_de_dados");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn === false) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    // Verifica se o formulário de cadastro foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtenha os valores dos campos do formulário
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $birthdate = $_POST['birthdate'];
        $street = $_POST['street'];
        $number = $_POST['number'];
        $neighborhood = $_POST['neighborhood'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $gender = $_POST['gender'];
        $maritalstatus = $_POST['maritalstatus'];

        // Insere os valores no banco de dados
        $query = "INSERT INTO users (username, name, email, password, birthdate, street, number, neighborhood, zipcode, city, state, gender, maritalstatus) VALUES ('$username', '$name', '$email', '$password', '$birthdate', '$street', '$number', '$neighborhood', '$zipcode', '$city', '$state', '$gender', '$maritalstatus')";
        $result = mysqli_query($conn, $query);

        // Verifica se o cadastro foi realizado com sucesso
        if ($result) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário: " . mysqli_error($conn);
        }
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
?>