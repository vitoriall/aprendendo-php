<?php
include_once 'menu.php';
include_once 'conexao.php';
$menu = new Menu();
$cc = new Conexao();

/* Passo 1)
* 	Existe paginaAtual sendo passada na URL?
* 	Sim: pega a pagina pelo get
* 	Nao: define que sera a pagina 1
*/
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;       //Atribuicao da pagina

//Passo 2) Seleciona no banco de dados todos os dados da tabela que queremos exibir
$selectAll = "SELECT * FROM tb_lista";
$queryAll = mysqli_query($cc->setDB(), $selectAll);

//Passo 3) Conta quantas linhas foram retornadas na nossa consulta
$totalLinhas = mysqli_num_rows($queryAll);

//Passo 4) Definindo quantas linhas queremos exibir em cada pagina
$linhasPorPagina = 10;

//Passo 5) Calcular quantas paginas irao existir, basta dividir totalLinhas/linhasPorPagina
$totalPaginas = ceil($totalLinhas / $linhasPorPagina );      //ceil AREDONDA O VALOR PARA NÃO FICAR NUMEROS QUEBRADOS

/* Passo 6) Como vou saber quais itens exibir em cada pagina?
*	Definindo, dentro da nossa lista, um intervalo
*	Definindo INICIO e FIM
*/
$inicioLista = ($linhasPorPagina  * $paginaAtual) - $linhasPorPagina ;


/* Passo 7) Seleciona os itens que serão apresentados na pagina atual
*	O comando LIMIT define um intervalo dentro da consulta/select
*	Ou seja, o inicio foi definido no passo anterior
*	E o LIMIT vai limitar a exibição em 10 itens
*	Inicio: $inicioLista
*	Fim: $linhasPorPagina
*/
$selectLista = "SELECT * FROM tb_lista LIMIT $inicioLista, $linhasPorPagina";

/*Pronto, os itens que queremos exibir estão guardados na variavel queryLista
* É so usar a variavel no while para exibir
*/
$queryLista = mysqli_query($cc->setDB(), $selectLista);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class='row'>
        <?php
        //Apresentando a lista de itens
        while ($itemLista = mysqli_fetch_assoc($queryLista)) {
            echo $itemLista['id'] . "<br>";
            echo $itemLista['nome'] . "<br>";
        }
        ?>
    </div>

    <?php
    $paginaAnterior = $paginaAtual - 1; //Reduz uma pagina
    $paginaSeguinte = $paginaAtual + 1; //Aumenta uma pagina
    ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!--Botao voltar para pagina anterior-->
            <?php if ($paginaAnterior != 0) { ?>
                <li class="page-item">
                    <a class="page-link" href="teste.php?pagina=<?php echo $paginaAnterior ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>

            <!--Mostra todas as paginas
		O for vai listar um botao para cada pagina enquanto i for menor que o total de paginas-->
            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                <li class="page-item"><a class="page-link" href="teste.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php } ?>

            <!--Botao passar para prox pagina-->
            <?php if ($paginaAnterior != 0) { ?>
                <li class="page-item">
                    <a class="page-link" href="teste.php?pagina=<?php echo $paginaSeguinte ?>" aria-label="Previous">
                    <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</body>

</html>