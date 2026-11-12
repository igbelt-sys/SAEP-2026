<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\ConexaoBanco;
use App\Core\Criptografia;
use PDOException;
use PDO;

final class Tutor {
    private static function pdo(): PDO {
        return ConexaoBanco::obterConexao(dirname(__DIR__, 2) . '/config/database.ini');
    }

    public static function listar(?string $termo = null): array {
        $sql = 'SELECT * FROM tutores';
        $params = [];

        if ($termo !== null && $termo !== '') {
            $sql .= ' WHERE nome ILIKE :termo OR email ILIKE :termo OR telefone ILIKE :termo';
            $params[':termo'] = '%' . trim($termo) . '%';
        }

        $sql .= ' ORDER BY nome ASC';
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function buscarPorId(int $id): ?array {
        $sql = 'SELECT * FROM tutores WHERE id = :id LIMIT 1';
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $tutor = $stmt->fetch();
        return $tutor ?: null;
    }

    public static function salvar(string $nome, string $cpf, string $telefone, string $email): bool {
        $sql = 'INSERT INTO tutores (nome, cpf_criptografado, telefone, email) VALUES (:nome, :cpf, :telefone, :email)';
        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            ':nome' => trim($nome),
            ':cpf' => Criptografia::criptografarCpf($cpf),
            ':telefone' => trim($telefone),
            ':email' => trim($email),
        ]);
    }

    public static function atualizar(int $id, string $nome, string $cpf, string $telefone, string $email): bool {
        $sql = 'UPDATE tutores SET nome = :nome, telefone = :telefone, email = :email';
        $params = [
            ':id' => $id,
            ':nome' => trim($nome),
            ':telefone' => trim($telefone),
            ':email' => trim($email),
        ];

        if (trim($cpf) !== '') {
            $sql .= ', cpf_criptografado = :cpf';
            $params[':cpf'] = Criptografia::criptografarCpf($cpf);
        }

        $sql .= ' WHERE id = :id';
        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute($params);
    }

    public static function excluir(int $id): bool {
        $stmt = self::pdo()->prepare('DELETE FROM tutores WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
