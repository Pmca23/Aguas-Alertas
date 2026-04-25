# Base de Dados — Águas Alerta · V.I.R.

Pasta com todos os ficheiros SQL do projeto **V.I.R. (Vigilância e Inspeção de Rios)**.

## Estrutura dos ficheiros

| Ficheiro | Descrição |
|----------|-----------|
| `create_db.sql` | Criação da base de dados e das 5 tabelas |
| `views_para_backend.sql` | Views para o dashboard e backoffice |
| `populate_db_teste.sql` | Dados de teste (estações, leituras, alertas) |

---

## 1. Criação da Base de Dados

Cria a base de dados `vir_db` e as 5 tabelas principais.

```sql
CREATE DATABASE IF NOT EXISTS vir_db
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE vir_db;

-- TABELA: estacoes
-- Cada dispositivo Arduino instalado no rio
CREATE TABLE estacoes (
    id_estacao            INT          NOT NULL AUTO_INCREMENT,
    nome                  VARCHAR(100) NOT NULL,
    localizacao           VARCHAR(200) NOT NULL,
    latitude              DECIMAL(9,6)     NULL,
    longitude             DECIMAL(9,6)     NULL,
    nivel_max_seguranca   FLOAT        NOT NULL COMMENT 'metros',
    caudal_max_seguranca  FLOAT        NOT NULL COMMENT 'L/min',
    data_instalacao       DATE             NULL,

    PRIMARY KEY (id_estacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- TABELA: leituras
-- Cada medição enviada pelo sensor ao servidor
CREATE TABLE leituras (
    id_leitura   INT      NOT NULL AUTO_INCREMENT,
    id_estacao   INT      NOT NULL,
    timestamp    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nivel_agua   FLOAT    NOT NULL COMMENT 'metros',
    caudal       FLOAT    NOT NULL COMMENT 'L/min',
    temperatura  FLOAT        NULL COMMENT 'graus Celsius',
    em_alerta    BOOLEAN  NOT NULL DEFAULT FALSE,

    PRIMARY KEY (id_leitura),
    FOREIGN KEY (id_estacao) REFERENCES estacoes(id_estacao)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_leituras_estacao   (id_estacao),
    INDEX idx_leituras_timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- TABELA: alertas
-- Gerado automaticamente quando limite de segurança é excedido
CREATE TABLE alertas (
    id_alerta       INT      NOT NULL AUTO_INCREMENT,
    id_estacao      INT      NOT NULL,
    tipo            ENUM('nivel', 'caudal', 'ambos') NOT NULL,
    nivel_critico   FLOAT        NULL COMMENT 'valor no momento do alerta',
    caudal_critico  FLOAT        NULL COMMENT 'valor no momento do alerta',
    data_hora       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado          ENUM('ativo', 'resolvido') NOT NULL DEFAULT 'ativo',
    resolvido_em    DATETIME     NULL,

    PRIMARY KEY (id_alerta),
    FOREIGN KEY (id_estacao) REFERENCES estacoes(id_estacao)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_alertas_estacao (id_estacao),
    INDEX idx_alertas_estado  (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- TABELA: localidades
-- Populações/entidades a notificar por cada estação
CREATE TABLE localidades (
    id_localidade    INT          NOT NULL AUTO_INCREMENT,
    id_estacao       INT          NOT NULL,
    nome             VARCHAR(100) NOT NULL,
    contacto_email   VARCHAR(150)     NULL,
    contacto_tel     VARCHAR(20)      NULL,
    nivel_prioridade INT          NOT NULL DEFAULT 1
        COMMENT '1 = alta prioridade, 2 = média, 3 = baixa',

    PRIMARY KEY (id_localidade),
    FOREIGN KEY (id_estacao) REFERENCES estacoes(id_estacao)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_localidades_estacao (id_estacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- TABELA: notificacoes
-- Histórico de cada mensagem enviada
CREATE TABLE notificacoes (
    id_notif       INT      NOT NULL AUTO_INCREMENT,
    id_alerta      INT      NOT NULL,
    id_localidade  INT      NOT NULL,
    canal          ENUM('email', 'sms', 'sirene') NOT NULL,
    enviada_em     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sucesso        BOOLEAN  NOT NULL DEFAULT TRUE,

    PRIMARY KEY (id_notif),
    FOREIGN KEY (id_alerta)     REFERENCES alertas(id_alerta)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_localidade) REFERENCES localidades(id_localidade)
        ON DELETE CASCADE ON UPDATE CASCADE,

    INDEX idx_notif_alerta     (id_alerta),
    INDEX idx_notif_localidade (id_localidade)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 2. Views para o Backend

Views prontas a usar nos endpoints PHP do servidor.

```sql
-- Vista: última leitura de cada estação
CREATE OR REPLACE VIEW v_ultima_leitura AS
SELECT
    e.id_estacao,
    e.nome                   AS estacao,
    e.localizacao,
    e.latitude,
    e.longitude,
    e.nivel_max_seguranca,
    e.caudal_max_seguranca,
    l.timestamp,
    l.nivel_agua,
    l.caudal,
    l.temperatura,
    l.em_alerta,
    ROUND((l.nivel_agua / e.nivel_max_seguranca) * 100, 1)  AS pct_nivel,
    ROUND((l.caudal     / e.caudal_max_seguranca) * 100, 1) AS pct_caudal
FROM estacoes e
JOIN leituras l ON l.id_leitura = (
    SELECT id_leitura FROM leituras
    WHERE id_estacao = e.id_estacao
    ORDER BY timestamp DESC
    LIMIT 1
);

-- Vista: alertas ativos com nome da estação
CREATE OR REPLACE VIEW v_alertas_ativos AS
SELECT
    a.id_alerta,
    e.nome          AS estacao,
    e.localizacao,
    a.tipo,
    a.nivel_critico,
    a.caudal_critico,
    a.data_hora,
    a.estado,
    TIMESTAMPDIFF(MINUTE, a.data_hora, NOW()) AS minutos_ativo
FROM alertas a
JOIN estacoes e ON e.id_estacao = a.id_estacao
WHERE a.estado = 'ativo'
ORDER BY a.data_hora DESC;

-- Vista: estatísticas por estação (para dashboard backoffice)
CREATE OR REPLACE VIEW v_estatisticas AS
SELECT
    e.id_estacao,
    e.nome,
    COUNT(l.id_leitura)                                      AS total_leituras,
    ROUND(AVG(l.nivel_agua), 2)                              AS nivel_medio,
    ROUND(MAX(l.nivel_agua), 2)                              AS nivel_maximo,
    ROUND(AVG(l.caudal), 2)                                  AS caudal_medio,
    SUM(l.em_alerta)                                         AS leituras_em_alerta,
    (SELECT COUNT(*) FROM alertas a
     WHERE a.id_estacao = e.id_estacao)                      AS total_alertas,
    (SELECT COUNT(*) FROM alertas a
     WHERE a.id_estacao = e.id_estacao AND a.estado='ativo') AS alertas_ativos
FROM estacoes e
LEFT JOIN leituras l ON l.id_estacao = e.id_estacao
GROUP BY e.id_estacao, e.nome;
```

---

## 3. Dados de Teste

Popula a base de dados com 3 estações, localidades, leituras de exemplo e um alerta ativo.

```sql
-- Estações
INSERT INTO estacoes
    (nome, localizacao, latitude, longitude, nivel_max_seguranca, caudal_max_seguranca, data_instalacao)
VALUES
    ('V.I.R. Estação Tejo — Santarém',   'Santarém', 39.236900, -8.688100, 5.0, 150.0, '2026-03-01'),
    ('V.I.R. Estação Douro — Porto',     'Porto',    41.157900, -8.629100, 4.5, 120.0, '2026-03-01'),
    ('V.I.R. Estação Mondego — Coimbra', 'Coimbra',  40.205600, -8.419400, 4.0, 100.0, '2026-03-08');

-- Localidades associadas às estações
INSERT INTO localidades
    (id_estacao, nome, contacto_email, contacto_tel, nivel_prioridade)
VALUES
    (1, 'Câmara Municipal de Santarém',  'protcivil@cm-santarem.pt', '243300000', 1),
    (1, 'Junta de Freguesia do Alfange', 'junta@alfange.pt',          '243111000', 2),
    (2, 'Câmara Municipal do Porto',     'protcivil@cm-porto.pt',    '222097000', 1),
    (3, 'Câmara Municipal de Coimbra',   'protcivil@cm-coimbra.pt',  '239857000', 1);

-- Leituras de exemplo (normais + 1 em alerta)
INSERT INTO leituras
    (id_estacao, timestamp, nivel_agua, caudal, temperatura, em_alerta)
VALUES
    (1, NOW() - INTERVAL 40 MINUTE, 2.10,  45.2,  14.5, FALSE),
    (1, NOW() - INTERVAL 30 MINUTE, 2.35,  52.0,  14.3, FALSE),
    (1, NOW() - INTERVAL 20 MINUTE, 3.80,  95.0,  14.1, FALSE),
    (1, NOW() - INTERVAL 10 MINUTE, 4.90, 138.0,  13.9, FALSE),
    (1, NOW(),                       5.80, 162.0,  13.7, TRUE),  -- ALERTA
    (2, NOW() - INTERVAL 20 MINUTE, 1.90,  38.0,  12.0, FALSE),
    (2, NOW(),                       2.10,  42.0,  11.8, FALSE),
    (3, NOW() - INTERVAL 15 MINUTE, 1.50,  28.0,  13.2, FALSE),
    (3, NOW(),                       1.65,  31.0,  13.0, FALSE);

-- Alerta gerado pela leitura crítica da Estação Tejo
INSERT INTO alertas
    (id_estacao, tipo, nivel_critico, caudal_critico, estado)
VALUES
    (1, 'ambos', 5.80, 162.0, 'ativo');

-- Notificações enviadas para o alerta 1
INSERT INTO notificacoes
    (id_alerta, id_localidade, canal, sucesso)
VALUES
    (1, 1, 'email',  TRUE),
    (1, 1, 'sms',    TRUE),
    (1, 1, 'sirene', TRUE),
    (1, 2, 'email',  TRUE),
    (1, 2, 'sms',    FALSE);  -- exemplo de falha de envio
```

---

## Como importar

**MySQL Workbench:**
1. File → Open SQL Script → seleciona o ficheiro
2. Clica no raio ⚡ (Execute)

**Linha de comandos:**
```bash
mysql -u root -p < create_db.sql
mysql -u root -p vir_db < views_para_backend.sql
mysql -u root -p vir_db < populate_db_teste.sql
```

---

*Águas Alerta · V.I.R. — Universidade Europeia — 2026*
