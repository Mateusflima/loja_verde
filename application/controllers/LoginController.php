<?php

session_start();
use Application\core\Controller;
use Application\dao\UsuarioDAO;
use Application\models\Usuario;
use Application\dao\ProdutoDAO;
use Application\models\Produto;

class LoginController extends Controller
{
    public function index()
    {
        $this->view('login/index');
    }



   public function autenticar_login()
  {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->buscarPorEmail($email);
    
    if (!empty($usuarios)) {
        $usuario = $usuarios[0];
    if (password_verify($senha, $usuario->getSenha())) {
        $_SESSION['usuario'] = $usuario;
        $this->view('home/index', ['msg' => 'Login realizado com sucesso.']);
    } else {
        $this->view('login/index', ['msg' => 'Nome ou senha incorretos.']);
        }
        } else {
            $this->view('login/index', ['msg' => 'Nome ou senha incorretos.']);
  }
 }

public function autenticar_login()
{
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha_login = $_POST['senha'];

    $usuarioDAO = new UsuarioDAO();
    
    $usuario = $usuarioDAO->buscarPorEmail($login);

    if (!$usuario || !password_verify($senha_login, $usuario->getSenha())) {
        $_SESSION['logado'] = false;
        $this->view('/login/index', ["msg-invalido" => "Credenciais inválidas"]);
        return;
    }

    $_SESSION['usuario'] = $usuario;
    $_SESSION['logado'] = $login;

    $produtoDAO = new ProdutoDAO();
    $produtos = $produtoDAO->findAll();

    $this->view('/home/index', ["msg-valido" => "Logado com sucesso!", "produtos" => $produtos]);
}

    public function logout()
    {
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();
            $this->view('/login/index', ["msg-logout" => "Deslogado com sucesso!"]);
        }

    }
}
?>