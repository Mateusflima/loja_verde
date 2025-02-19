<?php

use Application\core\Controller;
use Application\dao\ProdutoDAO;
use Application\models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtoDAO = new ProdutoDAO();
        $produtos = $produtoDAO->findAll();

        $this->view('produto/index', ['produtos' => $produtos]);
    }
    public function cadastrar()
    {
        $this->view('produto/cadastrar');
    }
    public function salvar()
    {
        $nome = $_POST['nome_produto'];
        $marca = $_POST['marca'];
        $preco = $_POST['preco'];
        $imagem_url = $_POST['imagem_url'];
        $produto = new Produto($nome, $marca, $preco, $imagem_url);        

        $produtoDAO = new ProdutoDAO();
        $produtoDAO->salvar($produto);

        $this->view('produto/cadastrar', ["msg" => "Produto criado com Sucesso!"]);
    }

    public function iniciarEditar($codigo)
    {
        $produtoDAO = new ProdutoDAO();
        $produto = $produtoDAO->findById($codigo);
        $this->view('produto/editar', ["produto" => $produto]);
    }

    public function atualizar()
    {
        $codigo = filter_input(INPUT_POST, "codigo");
        $nome = filter_input(INPUT_POST, "nome");
        $marca = filter_input(INPUT_POST, "marca");
        $preco = filter_input(INPUT_POST, "preco");
        $imagem_url = filter_input(INPUT_POST, "imagem_url");

        $produto = new Produto($nome, $marca, $preco, $imagem_url);
        $produto->setCodigo($codigo);
        $produtoDAO = new ProdutoDAO();
        $produtoAtualizado = $produtoDAO->atualizar($produto);
        if ($produtoAtualizado) {
            $msg = "Sucesso";
        } else {
            $msg = "Erro ao editar";
        }
        $this->view("produto/editar", ["msg" => $msg, "produto" => $produtoAtualizado]);
    }

    public function deletar()
    {
        $codigo = filter_input(INPUT_POST, "codigo");
        $produtoDAO = new ProdutoDAO();
        if ($produtoDAO->deletar($codigo)) {
            $msg = "Sucessoooo";
        } else {
            $msg = "Deu errooo ";
        }
        $produtos = $produtoDAO->findAll();
        $this->view("produto/index", ["msg-deletar" => $msg, "produtos" => $produtos]);
    }
}
?>