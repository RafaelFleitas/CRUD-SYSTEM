<?php
session_start();
require __DIR__ . '/../config/conexao.php';

if(isset($_POST['email']) && isset($_POST['senha'])){
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = " SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexao, $sql);

    if(mysqli_num_rows($result)==1){
        $usuario = mysqli_fetch_assoc($result);

        if(password_verify($senha, $usuario['senha'])){

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['logado'] = true;
        header('Location: /../index.php');
        exit;

    } else{
        echo "<script>alert('Email ou senha incorretos.');</script>";
    }
    } else{
        echo "<script>alert('Email ou senha incorretos.');</script>";
    }
}
?>

<!doctype html>
<html lang="PT-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Área de login
                        </h4>
                    </div>
                    <div class= "card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label>Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='../views/usuario-create.php'">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>