# V.I.R. REST API Documentation

## Autenticação

A API utiliza autenticação baseada em JWT (JSON Web Tokens).

Para aceder a endpoints protegidos:

```plaintext
Authorization: Bearer
Base URL
http://localhost/vir/backend/
Endpoints
Auth
Login

Autentica um utilizador existente.

POST /auth/login.php

Request Body
{
  "email": "admin@vir.pt",
  "password": "admin123"
}

ou

{
  "email": "tecnico@vir.pt",
  "password": "tecnico123"
}
Response: 200 OK
{
  "status": "ok",
  "token": "eyJhbGciOi...",
  "user": {
    "id": 1,
    "nome": "Admin",
    "role": "admin"
  }
}
Logout

Termina sessão/token atual.

POST /auth/logout.php

Response: 200 OK
{
  "status": "ok",
  "mensagem": "Logout efetuado"
}
Técnico

Necessário login técnico + Bearer Token.

Dashboard Técnico

Retorna resumo geral para painel técnico.

GET /api/private/tecnico/dashboard_tecnico.php

Response: 200 OK
{
  "status": "ok",
  "data": {
    "nivel_atual": 4.2,
    "media": 3.8,
    "maximo": 6.1,
    "alertas": 1
  }
}
Histórico por Período

Retorna leituras históricas.

GET /api/private/tecnico/historico_periodo.php?id_estacao=1&dias=7

Parameters
id_estacao (required)
dias (optional)
Response: 200 OK
{
  "status": "ok",
  "total_registos": 25,
  "data": []
}
Estatísticas do Rio

Retorna estatísticas da estação.

GET /api/private/tecnico/estatisticas_rio.php?id_estacao=1

Response: 200 OK
{
  "status": "ok",
  "data": {
    "media": 3.4,
    "maximo": 6.2,
    "minimo": 1.8,
    "total": 40
  }
}
Análise do Rio

Retorna tendência atual.

GET /api/private/tecnico/analise_rio.php?id_estacao=1

Response: 200 OK
{
  "status": "ok",
  "analise": "Nível a subir"
}
Alterar Alerta

Atualiza nível crítico ativo.

POST /api/private/tecnico/alterar_alerta.php

Request Body
{
  "id_estacao": 1,
  "nivel_critico": 6.5
}
Response: 200 OK
{
  "status": "ok",
  "mensagem": "Nível de alerta atualizado"
}
Registar Observação

Adiciona observação técnica.

POST /api/private/tecnico/registar_observacao.php

Request Body
{
  "id_estacao": 1,
  "observacao": "Subida rápida após chuva intensa"
}
Response: 200 OK
{
  "status": "ok",
  "mensagem": "Observação registada"
}
Listar Observações

Lista observações de uma estação.

GET /api/private/tecnico/listar_observacoes.php?id_estacao=1

Response: 200 OK
{
  "status": "ok",
  "total": 3,
  "data": []
}
Listar Emails

Lista notificações simuladas enviadas.

GET /api/private/tecnico/listar_emails.php

Response: 200 OK
{
  "status": "ok",
  "total": 2,
  "emails": []
}
Admin

Necessário login admin + Bearer Token.

Dashboard Admin

Resumo geral do sistema.

GET /api/private/admin/dashboard_admin.php

Response: 200 OK
{
  "status": "ok",
  "data": {
    "total_estacoes": 5,
    "alertas_ativos": 1,
    "media_nivel_agua": 3.2,
    "total_utilizadores": 2
  }
}
Listar Utilizadores

Lista todos os utilizadores.

GET /api/private/admin/listar_utilizadores.php

Response: 200 OK
{
  "status": "ok",
  "total_utilizadores": 2,
  "data": []
}
Criar Técnico

Cria novo utilizador técnico.

POST /api/private/admin/criar_tecnico.php

Request Body
{
  "nome": "Novo Técnico",
  "email": "novo@vir.pt",
  "password": "123456"
}
Response: 200 OK
{
  "status": "ok",
  "mensagem": "Técnico criado com sucesso"
}
Eliminar Utilizador

Remove técnico existente.

POST /api/private/admin/eliminar_utilizador.php

Request Body
{
  "id_utilizador": 5
}
Response: 200 OK
{
  "status": "ok",
  "mensagem": "Técnico eliminado"
}
Estatísticas

Retorna métricas globais.

GET /api/private/admin/estatisticas.php

Response: 200 OK
{
  "status": "ok",
  "data": {}
}
Leituras
Inserir Leitura

Regista nova leitura manualmente.

POST /api/private/inserir_leitura.php

Request Body
{
  "id_estacao": 1,
  "nivel": 7.5,
  "temperatura": 14
}
Funções Automáticas
Regista leitura
Verifica limite de segurança
Cria alerta
Envia emails para localidades afetadas
Regista notificações
Response: 200 OK
{
  "status": "ok",
  "mensagem": "Leitura registada",
  "emails_enviados": 2
}
API Pública

Sem autenticação.

Última Leitura

GET /api/public/ultima_leitura.php

Alertas Ativos

GET /api/public/alertas_ativos.php

Histórico Público

GET /api/public/historico.php

Url base da api é http://localhost/Aguas-Alertas/Backend/backend/api/
Email: admin@aguasalerta.pt
Password: admin123

http://localhost/Aguas-Alertas/Frontend/index.html