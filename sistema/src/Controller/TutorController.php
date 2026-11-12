<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Tutor;
use PDOException;

/**
 * Controller para gerenciamento, cadastro, busca e edicao de tutores.
 */
final class TutorController extends Controller {
    //listar todos os tutores
    public function listar(): void {
        $termo = trim((string)($_GET['q'] ?? ''));
        $tutores = Tutor::listar($termo !== '' ? $termo : null);
        $this->renderizar('tutores/listar', [
            'titulo'  => 'Gerenciamento de Tutores',
            'tutores' => $tutores,
            'busca'   => $termo
        ]);
    }
    //renderizar o formulario de cadastro
    public function formulario(): void {
        $this->renderizar('tutores/criar', [
            'titulo'    => 'Novo Tutor',
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }
    //salvar o tutor no banco
    public function salvar(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirecionar('/tutores');
        }
        $nome = trim($_POST['nome'] ?? '');
        $cpf  = trim($_POST['cpf'] ?? '');
        $tel  = trim($_POST['telefone'] ?? '');
        $mail = trim($_POST['email'] ?? '');
        if ($nome !== '' && $cpf !== '' && $tel !== '') {
            Tutor::salvar($nome, $cpf, $tel, $mail);
            $this->redirecionar('/tutores');
        }
        $this->renderizar('tutores/criar', [
            'titulo'    => 'Novo Tutor',
            'erro'      => 'Preencha todos os campos obrigatórios.',
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }

    //renderizar a informações de um tutor selecionado
    public function formularioEdicao(): void {
        $id = (int)($_GET['id'] ?? 0);
        $tutor = Tutor::buscarPorId($id);
        if (!$tutor) {
            $this->redirecionar('/tutores');
        }
        $this->renderizar('tutores/editar', [
            'titulo'    => 'Editar Dados do Tutor',
            'tutor'     => $tutor,
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }

    //atualizar as informaços 
    public function atualizar(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirecionar('/tutores');
        }
        $id   = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $cpf  = trim($_POST['cpf'] ?? '');
        $tel  = trim($_POST['telefone'] ?? '');
        $mail = trim($_POST['email'] ?? '');
        if ($id > 0 && $nome !== '') {
            Tutor::atualizar($id, $nome, $cpf, $tel, $mail);
            $this->redirecionar('/tutores');
        }
        $this->redirecionar('/tutores/editar?id=' . $id);
    }

    public function excluir(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            echo 'Token CSRF inválido ou expirado.';
            return;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id < 1) {
            $this->redirecionar('/tutores');
        }

        try {
            Tutor::excluir($id);
            $this->redirecionar('/tutores');
        } catch (PDOException) {
            $this->renderizar('tutores/listar', [
                'titulo' => 'Gerenciamento de Tutores',
                'tutores' => Tutor::listar(),
                'busca' => '',
                'erro' => 'Não foi possível excluir o tutor porque existem registros vinculados a ele.'
            ]);
        }
    }
}