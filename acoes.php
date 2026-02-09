<?php
session_start();
require 'conexao.php';

// INSERT USUÁRIO IN DATABASE
if(isset($_POST['create_usuario'])){
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';


    // Verify if any field is empty
    if (empty($nome) || empty($email) || empty($data_nascimento) || empty(trim($_POST['senha']))) {
        $_SESSION['message'] = "Todos os campos são obrigatórios!";
        header('Location: index.php');
        exit;
    }

    //VERIFY IF EMAIL IS VALID
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Email inválido!";
        header('Location: index.php');
        exit;
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

// UPDATE USUÁRIO IN DATABASE
if(isset($_POST['update_usuario'])){
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));


    $sql = "UPDATE usuarios SET nome='$nome', email='$email', data_nascimento='$data_nascimento'";

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

//DELETE USUÁRIO IN DATABASE
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