<?php


require __DIR__ . '/config/conexao.php';

$busca = mysqli_real_escape_string($conexao, $_GET['busca'] ?? '');

if(!empty($_GET['busca'])){
    $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%'";
} else {
    $sql = 'SELECT * FROM usuarios';
}
$usuarios = mysqli_query($conexao, $sql);

if(mysqli_num_rows($usuarios) > 0){
    foreach ($usuarios as $usuario){
        ?>
        <tr>
            <td><?=$usuario['id']?></td>
            <td><?=$usuario['nome']?></td>
            <td><?=$usuario['email']?></td>
            <td><?=date('d/m/Y', strtotime($usuario['data_nascimento']))?></td>
            <td>
                <a href="/views/usuario-view.php?id=<?=$usuario['id']?>" class="btn btn-secondary btn-sm"><span class="bi-eye-fill"></span>&nbsp;Visualizar</a>
                <a href="/views/usuario-edit.php?id=<?=$usuario['id']?>" class="btn btn-success btn-sm"><span class="bi-pencil-fill"></span>&nbsp;Editar</a>
                <form action="acoes.php" method="POST" class="d-inline">
                    <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_usuario" value="<?=$usuario['id']?>" class="btn btn-danger btn-sm"><span class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                </form>
            </td>
        </tr>
        <?php
    }
} else {
    echo '<tr><td colspan="5" class="text-center">Nenhum usuário encontrado</td></tr>';
}
?>