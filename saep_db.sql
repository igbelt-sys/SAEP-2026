-- ================================================
-- Script de Criação e População do Banco de Dados
-- ================================================

-- Conecte-se ao banco vet_db antes de executar este arquivo.
-- 1. Criação da Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    senha_hash VARCHAR(128) NOT NULL,
    perfil VARCHAR(128) NOT NULL CHECK (perfil IN ('admin', 'veterinario', 'recepcionista')),
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX IF NOT EXISTS usuarios_email_unique_idx ON usuarios(email);

-- 2. Criação da Tabela de Tutores
CREATE TABLE IF NOT EXISTS tutores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(128) NOT NULL,
    cpf_criptografado VARCHAR(128) NOT NULL,
    telefone VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. Criação da Tabela de Pets
CREATE TABLE IF NOT EXISTS pets (
    id SERIAL PRIMARY KEY,
    tutor_id INTEGER NOT NULL REFERENCES tutores(id) ON DELETE CASCADE,
    nome VARCHAR(128) NOT NULL,
    especie VARCHAR(128) NOT NULL,
    raca VARCHAR(128) NOT NULL,
    data_nascimento DATE NOT NULL,
    cadastrado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. Criação da Tabela de Agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id SERIAL PRIMARY KEY,
    tutor_id INTEGER NOT NULL REFERENCES tutores(id) ON DELETE RESTRICT,
    pet_id INTEGER NOT NULL REFERENCES pets(id) ON DELETE RESTRICT,
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE RESTRICT,
    data_agendamento DATE NOT NULL,
    hora_agendamento TIME NOT NULL,
    servico VARCHAR(128) NOT NULL,
    status VARCHAR(128) NOT NULL DEFAULT 'AGENDADO' CHECK (status IN ('AGENDADO', 'CONCLUIDO', 'CANCELADO')),
    observacao TEXT,
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);


-- =============================================================================
-- CARGA INICIAL DE DADOS (Pelo menos 3 registros por tabela)
-- =============================================================================

-- Usuários: Senha padrão para todos: '123456'
INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES
('Dra. Helena Martins', 'helena.martins@vetbemestar.com', '$argon2id$v=19$m=65536,t=4,p=1$VXZPQW9WMmtMd3hvNzRpcg$J2/jDojr9SHZrX4nBpQXImeJjrlZ977nJMK2LEd8JS0', 'veterinario'),
('Rafael Nogueira', 'rafael.nogueira@vetbemestar.com', '$argon2id$v=19$m=65536,t=4,p=1$VXZPQW9WMmtMd3hvNzRpcg$J2/jDojr9SHZrX4nBpQXImeJjrlZ977nJMK2LEd8JS0', 'recepcionista'),
('Juliana Freitas', 'juliana.freitas@vetbemestar.com', '$argon2id$v=19$m=65536,t=4,p=1$VXZPQW9WMmtMd3hvNzRpcg$J2/jDojr9SHZrX4nBpQXImeJjrlZ977nJMK2LEd8JS0', 'admin')
ON CONFLICT (email) DO NOTHING;

-- Tutores: CPFs armazenados criptografados em Base64 (AES-256-CBC).
-- Os valores abaixo foram gerados com a chave de desenvolvimento em sistema/config/database.ini.
-- CPFs originais de teste: 111.222.333-44, 555.666.777-88 e 999.888.777-66.
INSERT INTO tutores (id, nome, cpf_criptografado, telefone, email) VALUES
(1, 'Marina Alves Rocha', '4vO8rtN/gA+dMtj0+vygyeO5MBbrGhMOEx2kzats3PQ=', '(11) 98765-4321', 'marina.rocha@email.com'),
(2, 'Eduardo Campos Melo', 'P4Vs7parUlY19m+PUY+qxcreu51CWv3VSOUr5iaMa1Y=', '(11) 97654-3210', 'eduardo.melo@email.com'),
(3, 'Patricia Gomes Lima', 'RWrK28EtVPmq6Ge6OL54dd1zy4cvElIAX72m9T00Y1s=', '(19) 99123-4567', 'patricia.lima@email.com')
ON CONFLICT (id) DO NOTHING;

-- Pets: Cada pet obrigatoriamente associado ao seu tutor
INSERT INTO pets (id, tutor_id, nome, especie, raca, data_nascimento) VALUES
(1, 1, 'Thor', 'Canina', 'Golden Retriever', '2021-05-10'),
(2, 2, 'Mia', 'Felina', 'Siamês', '2022-08-15'),
(3, 3, 'Bob', 'Canina', 'Bulldog Francês', '2020-02-20')
ON CONFLICT (id) DO NOTHING;

-- Agendamentos: Datas diferentes para demonstrar a ordenação por data
INSERT INTO agendamentos (id, tutor_id, pet_id, usuario_id, data_agendamento, hora_agendamento, servico, status, observacao) VALUES
(1, 1, 1, 1, '2024-11-15', '09:30:00', 'Consulta Geral e Vacinação Anual', 'CONCLUIDO', 'Animal dócil e com carteira atualizada'),
(2, 2, 2, 1, '2025-06-20', '14:00:00', 'Profilaxia Dentária e Tartarectomia', 'CONCLUIDO', 'Exames pré-operatórios normais'),
(3, 3, 3, 2, '2026-03-10', '10:30:00', 'Check-up Preventivo e Exame de Sangue', 'AGENDADO', 'Paciente alérgico a dipirona')
ON CONFLICT (id) DO NOTHING;

-- Ajuste dos contadores das sequências para inserções futuras
SELECT setval('usuarios_id_seq', (SELECT MAX(id) FROM usuarios));
SELECT setval('tutores_id_seq', (SELECT MAX(id) FROM tutores));
SELECT setval('pets_id_seq', (SELECT MAX(id) FROM pets));
SELECT setval('agendamentos_id_seq', (SELECT MAX(id) FROM agendamentos));
