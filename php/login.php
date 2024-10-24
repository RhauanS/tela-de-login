<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Resultado</title>
    <link rel="stylesheet" href="../sites-extras/login-style.css">

</head>
<body>
    <div class="container">
        <div class="text-container">
            <?php
            session_start();
            include('dbconnection.php');

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $userId = htmlspecialchars($_POST['user']);
                $senha = htmlspecialchars($_POST['senha']);

                if(empty($userId) || empty($senha)) {
                    echo "<h1 style='color:red;'>Preencha os campos vazios</h1>";
                    exit;
                }

                $sql = "SELECT * FROM `usuariox` WHERE userID = ?";
                if($stmt = $conn->prepare($sql)){
                    $stmt->bind_param("s", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if($result->num_rows > 0){
                        $user = $result->fetch_assoc();
                        if(password_verify($senha, $user['senha'])){
                            echo "<h1 style='color:green;'>Seja bem-vindo, " . $user['nome'] . "!</h1>";
                        } else {
                            echo "<h1 style='color:red;'>Senha incorreta.</h1>";
                        }
                    } else {
                        echo "<h1 style='color:red;'>Usuário não encontrado.</h1>";
                    }
                    $stmt->close();
                } else {
                    echo "<h1 style='color:red;'>Falha ao consultar: " . $conn->error . "</h1>";
                }
            }

            $conn->close();
            ?>
        </div>

        <div class="img-container">
            <img src="../imagens/gif-cartoon.gif" alt="Stitch Chorando" class="infinite-gif">
        </div>

        <div class="button" style="margin-top: 30px;">
            <a href="../index.html">Início</a>
        </div>
    </div>
</body>
</html>
