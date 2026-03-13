<?php

use Dom\Mysql;

session_start();
require  __DIR__ . '/config/conexao.php';

$mensagem = "";
$tipo_alerta = "";


# INSERT USUÁRIO IN DATABASE
if(isset($_POST['create_usuario'])){
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));


    # Verify if any field is empty
    if (empty($nome) || empty($email) || empty($data_nascimento) || empty(trim($_POST['senha']))) {
        $_SESSION['message'] = "Todos os campos são obrigatórios!";
        header('Location: index.php');
        exit;
    }

    # VERIFY IF EMAIL IS VALID
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Email inválido!";
        header('Location: index.php');
        exit;
    } else {
        $sql = "SELECT id FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['message'] = "Email já cadastrado!";
            header('Location: index.php');
            exit;
        }
    }

    #VERIFY IF PASSWORD EXIST AND HAS AT LEAST 6 CHARACTERS
    if(empty($senha) || strlen($senha) < 6){
        $_SESSION['message'] = "A senha deve conter pelo menos 6 caracteres!";
        header('Location: index.php');
        exit;
    } else {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    
    $sql = "INSERT INTO usuarios( nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['message'] = "Usuário criado com sucesso!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = "Usuário não foi criado!";
        header('Location: index.php');
        exit;
    }
}

# UPDATE USUÁRIO IN DATABASE
if(isset($_POST['update_usuario'])){
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));


    $sql = "UPDATE usuarios SET nome='$nome', email='$email', data_nascimento='$data_nascimento'";

    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Email inválido!";
            header('Location: index.php');
            exit;
        } else {
            $sql_email = "SELECT id FROM usuarios WHERE email = '$email' AND id != '$usuario_id'";
            $result_email = mysqli_query($conexao, $sql_email);
            if (mysqli_num_rows($result_email) > 0) {
                $_SESSION['message'] = "Email já cadastrado por outro usuário!";
                header('Location: index.php');
                exit;
            }
        }
    }

    if (!empty($senha)){
        $sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
    }
    $sql .= " WHERE id='$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['message'] = "Usuário atualizado com sucesso!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = "Usuário não foi atualizado!";
        header('Location: index.php');
        exit;
    }
}

# DELETE USUÁRIO IN DATABASE
if(isset($_POST['delete_usuario'])){
    $usuario_id = mysqli_real_escape_string($conexao,$_POST['delete_usuario']);
    $sql = "DELETE FROM usuarios WHERE id='$usuario_id'";

    mysqli_query($conexao, $sql);

    if(mysqli_affected_rows($conexao) > 0){
        $_SESSION['message'] = "Usuário excluído com sucesso!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = "Usuário não foi excluído!";
        header('Location: index.php');
        exit;
    }
}
?>