GE<?php
require __DIR__ . '/dompdf/vendor/autoload.php';
require __DIR__ . '/config/conexao.php';

use Dompdf\Dompdf;
use Dompdf\Options;

# Verify if 'id' parameter is present in the URL
$usuario_id = mysqli_real_escape_string($conexao, $_GET['id']);
$sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$query = mysqli_query($conexao, $sql);


# Verify if user exists
if(mysqli_num_rows($query) > 0){
    $usuario = mysqli_fetch_array($query);
} else {
    die("Erro: Usuário não encontrado.");
}


$dompdf = new Dompdf();
$options = new Options();
$html= '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .ficha { border: 1px solid #333; padding: 20px; border-radius: 8px; }
        h1 { color: #444; text-align: center; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        .campo { font-weight: bold; margin-top: 15px; color: #555; }
        .valor { font-size: 18px; color: #000; margin-bottom: 5px; }
        .rodape { font-size: 12px; text-align: center; margin-top: 50px; color: #888; }
    </style>
</head>
<body>
    <div class="ficha">
        <h1>Ficha de Usuário</h1>
        
        <div class="campo">ID do Registro:</div>
        <div class="valor">'. $usuario['id'] .'</div>

        <div class="campo">Nome Completo:</div>
        <div class="valor">'. $usuario['nome'] .'</div>

        <div class="campo">E-mail:</div>
        <div class="valor">'. $usuario['email'] .'</div>

        <div class="campo">Data de Nascimento:</div>
        <div class="valor">'. date('d/m/Y', strtotime($usuario['data_nascimento'])) .'</div>
    </div>

    <div class="rodape">
        Relatório gerado automaticamente em '. date('d/m/Y H:i') .'
    </div>
</body>
</html>
';


$dompdf-> loadHtml($html);
$options->set('defaultFont', 'Helvetica');
$dompdf-> setPaper('A4', 'portrait');
$dompdf-> render();
$dompdf-> stream("Usuario_". $usuario['nome'] . "_id_".$usuario['id'].".pdf", ["Attachment" => false]);

?>