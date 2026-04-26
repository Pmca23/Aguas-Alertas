# V.I.R. API Documentation

Sistema backend para monitorização inteligente de rios, alertas automáticos e gestão operacional.

---

## Autenticação

A API utiliza autenticação baseada em JWT.

Para aceder a endpoints protegidos:

    Authorization: Bearer {seu-token-jwt}

---

## Base URL

    http://localhost/vir/backend/

---

# Auth

## Login

Autentica um utilizador existente.

**Endpoint**

    POST /auth/login.php

**Request**

    {
      "email": "admin@vir.pt",
      "password": "admin123"
    }

ou

    {
      "email": "tecnico@vir.pt",
      "password": "tecnico123"
    }

**Response**

    {
      "status": "ok",
      "token": "jwt_token",
      "user": {
        "id": 1,
        "nome": "Administrador",
        "role": "admin"
      }
    }

---

## Logout

Termina sessão atual.

**Endpoint**

    POST /auth/logout.php

**Response**

    {
      "status": "ok",
      "mensagem": "Logout efetuado"
    }

---

# Técnico

Requer utilizador com role técnico.

## Dashboard Técnico

    GET /api/private/tecnico/dashboard_tecnico.php

## Histórico por Período

    GET /api/private/tecnico/historico_periodo.php?id_estacao=1&dias=7

## Estatísticas do Rio

    GET /api/private/tecnico/estatisticas_rio.php?id_estacao=1

## Análise do Rio

    GET /api/private/tecnico/analise_rio.php?id_estacao=1

---

## Criar Alerta Manual

    POST /api/private/tecnico/criar_alerta.php

**Request**

    {
      "id_estacao": 1,
      "nivel_critico": 6.5,
      "tipo": "critico"
    }

Tipos:

- informacao
- aviso
- critico

---

## Resolver Alerta

    POST /api/private/tecnico/resolver_alerta.php

**Request**

    {
      "id_alerta": 1
    }

---

## Listar Alertas

    GET /api/private/tecnico/listar_alertas.php

---

## Alterar Alerta

    POST /api/private/tecnico/alterar_alerta.php

---

## Registar Observação

    POST /api/private/tecnico/registar_observacao.php

---

## Listar Observações

    GET /api/private/tecnico/listar_observacoes.php?id_estacao=1

---

## Listar Emails

    GET /api/private/tecnico/listar_emails.php

---

# Admin

Requer utilizador com role admin.

## Dashboard Admin

    GET /api/private/admin/dashboard_admin.php

## Listar Utilizadores

    GET /api/private/admin/listar_utilizadores.php

## Criar Técnico

    POST /api/private/admin/criar_tecnico.php

## Eliminar Utilizador

    POST /api/private/admin/eliminar_utilizador.php

## Estatísticas

    GET /api/private/admin/estatisticas.php

---

# Leituras

## Inserir Leitura

    POST /api/private/inserir_leitura.php

**Request**

    {
      "id_estacao": 1,
      "nivel": 7.5,
      "temperatura": 14
    }

Funções automáticas:

- Guarda leitura
- Verifica limite de segurança
- Cria alerta automático
- Envia emails
- Regista notificações

---

# Segurança

- Password Hashing
- JWT Authentication
- Bearer Token
- Proteção por Roles

---

# Estado Atual

Backend funcional e pronto para frontend.
