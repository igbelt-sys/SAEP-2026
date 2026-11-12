<?php
declare(strict_types=1);

namespace App\Core;

use Exception;

final class Criptografia {
    public static function criptografarCpf(string $cpf): string {
        $config = parse_ini_file(dirname(__DIR__, 2) . '/config/database.ini', true);
        $chave = (string)($config['security']['app_key'] ?? '');

        if ($chave === '') {
            throw new Exception('Chave de criptografia do CPF não configurada.');
        }

        $iv = random_bytes(16);
        $valorCriptografado = openssl_encrypt(
            $cpf,
            'AES-256-CBC',
            hash('sha256', $chave),
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($valorCriptografado === false) {
            throw new Exception('Falha ao criptografar o CPF.');
        }

        return base64_encode($iv . $valorCriptografado);
    }

    public static function descriptografarCpf(string $cpfCriptografado): string {
        $config = parse_ini_file(dirname(__DIR__, 2) . '/config/database.ini', true);
        $chave = (string)($config['security']['app_key'] ?? '');

        if ($chave === '') {
            throw new Exception('Chave de criptografia do CPF não configurada.');
        }

        $dados = base64_decode($cpfCriptografado, true);
        if ($dados === false || strlen($dados) <= 16) {
            throw new Exception('CPF armazenado em formato inválido.');
        }

        $iv = substr($dados, 0, 16);
        $conteudo = substr($dados, 16);
        $valor = openssl_decrypt(
            $conteudo,
            'AES-256-CBC',
            hash('sha256', $chave),
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($valor === false) {
            throw new Exception('Não foi possível descriptografar o CPF. Verifique a chave de segurança configurada.');
        }

        return $valor;
    }
}
