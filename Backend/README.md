# V.I.R. — Vigilância Inteligente de Rios

Sistema desenvolvido para monitorização de rios, prevenção de cheias e gestão de alertas em tempo real.

Este projeto permite recolher leituras de sensores, gerar alertas automáticos, notificar zonas afetadas e disponibilizar painéis distintos para administradores e técnicos.

---

# Objetivos do Projeto

- Monitorizar níveis de água em várias estações fluviais  
- Detetar situações de risco automaticamente  
- Gerar alertas de cheia  
- Notificar entidades/localidades afetadas  
- Disponibilizar dados históricos e estatísticos  

---

# Tecnologias Utilizadas

## Backend

- PHP 8
- MySQL
- JWT Authentication
- REST API
- XAMPP
- Composer

## Base de Dados

- MySQL Relational Database
- Stored Procedures
- SQL Views

## Testes

- Postman

---

# Estrutura da Base de Dados

Principais tabelas:

- `estacoes`
- `leituras`
- `alertas`
- `localidades`
- `notificacoes`
- `utilizadores`
- `observacoes`

---

# Sistema de Autenticação

Autenticação implementada com:

- Login por email e password
- Password Hashing
- JWT Token
- Bearer Authorization
- Proteção de rotas privadas

---

# Perfis de Utilizador

## Administrador

Permissões:

- Listar utilizadores
- Criar técnicos
- Eliminar utilizadores técnicos
- Consultar dashboard geral
- Estatísticas globais do sistema

## Técnico

Permissões:

- Consultar dados das estações
- Ver histórico por período
- Consultar estatísticas
- Alterar nível crítico de alerta
- Registar observações
- Consultar emails enviados

---

# Funcionalidades Principais

## Leituras de Sensores

Registo automático/manual de:

- Nível da água
- Temperatura
- Estado de alerta

## Alertas Inteligentes

Sempre que o nível ultrapassa o valor máximo de segurança:

- É criado alerta automático
- Sistema identifica zonas afetadas
- São geradas notificações

## Emails Simulados

Para efeitos académicos:

- Emails são simulados
- Registados em:

```plaintext
backend/logs/emails.txt
