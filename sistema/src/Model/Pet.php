<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\ConexaoBanco;
use PDO;

final class Pet {
    private static function pdo(): PDO {
        return ConexaoBanco::obterConexao(dirname(__DIR__, 2) . '/config/database.ini');
    }

    public static function listarTodos(): array {
        $sql = 'SELECT p.*, t.nome AS tutor_nome FROM pets p JOIN tutores t ON t.id = p.tutor_id ORDER BY p.nome ASC';
        $stmt = self::pdo()->query($sql);

        return $stmt->fetchAll();
    }

    public static function totalPets(): int {
        $stmt = self::pdo()->query('SELECT COUNT(*) AS total FROM pets');
        $res = $stmt->fetch();

        return (int)($res['total'] ?? 0);
    }

    public static function salvar(int $tutorId, string $nome, string $especie, string $raca, string $dataNascimento): bool {
        $sql = 'INSERT INTO pets (tutor_id, nome, especie, raca, data_nascimento) VALUES (:tutor_id, :nome, :especie, :raca, :data_nascimento)';
        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            ':tutor_id' => $tutorId,
            ':nome' => trim($nome),
            ':especie' => trim($especie),
            ':raca' => trim($raca),
            ':data_nascimento' => $dataNascimento,
        ]);
    }
}
