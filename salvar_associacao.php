<?php
include 'conexao.php';
$id_profissional = $_POST['id_profissional'];
$id_servico = $_POST['id_servico'];

mysqli_query($conn, "INSERT INTO profissional_servico (id_profissional, id_servico) VALUES ($id_profissional, $id_servico)");
echo "<script>alert('Associação realizada com sucesso!'); location.href='associar_profissional_servico.php';</script>";
?>