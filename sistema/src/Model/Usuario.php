<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\ConexaoBanco;
use PDO;

final class Usuario {
    private static function pdo(): PDO {
        return ConexaoBanco::obterConexao(dirname(__DIR__, 2) . '/config/database.ini');
    }

    public static function buscarPorEmail(string $email): ?array {
        $sql = 'SELECT * FROM usuarios WHERE email = :email LIMIT 1';
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':email' => trim($email)]);

        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }
}
