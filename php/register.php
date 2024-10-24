<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../sites-extras/login-style.css">
</head>
<body>
    <div class="container">
        <div class="text-container">
            <h1 style="font-size: 3.5rem; margin-bottom: 40px;">Olá! Bem-vindo ao nosso <br> site de registro</h1>            
        </div>

        <?php
        session_start();
        include('dbconnection.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = htmlspecialchars($_POST['nome']);
            $email = htmlspecialchars($_POST['email']);
            $userId = htmlspecialchars($_POST['userId']);
            $senha = htmlspecialchars($_POST['senha']);

            if (empty($nome) || empty($email) || empty($userId) || empty($senha)) {
                echo "<p style='color:red; text-align:center;'>Preencha os campos vazios</p>";
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p style='color:red; text-align:center;'>Insira um email válido</p>";
                exit;
            }

            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "SELECT * FROM `usuariox` WHERE userID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<p style='color:red; text-align:center;'>Usuário já cadastrado com esse ID</p>";
            } else {
                $sql = "INSERT INTO `usuariox` (nome, email, userID, senha) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $nome, $email, $userId, $senha_hash);

                if ($stmt->execute()) {
                    echo "<h1 style='color:green; text-align:center;'>Usuário cadastrado com sucesso</h1>";
                } else {
                    echo "<h1 style='color:red; text-align:center;'>Falha no cadastro: " . $conn->error . "</h1>";
                }
            }

            $stmt->close();
        }
        $conn->close();
        ?>

        <div class="button" style="margin-top: 30px;">
            <a href="../index.html">Início</a>
        </div>

        <div class="img-container">
            <img src="../imagens/gif-cartoon.gif" alt="Stitch Chorando" class="infinite-gif">
        </div>
    </div>
</body>
</html>
