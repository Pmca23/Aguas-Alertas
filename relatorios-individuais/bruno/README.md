# Relatório Individual de Atividade

**Estudante:** Bruno Gouveia

---
# Relatório Semanal 1

## Tarefas em Curso

Durante esta semana, o foco incidiu na fundação estratégica e visual do projeto. As atividades principais incluíram:

- **Nome e Identidade** — Definição do nome do projeto e desenvolvimento da identidade visual base.
- **Planeamento Estratégico** — Estruturação e tópicos essenciais para o pitch de apresentação.

---

## Reflexão Crítica

Encontramo-nos atualmente dentro do cronograma previsto, sem registo de atrasos face aos objetivos iniciais. Esta fase de definição foi crucial para garantir a coerência do projeto nas etapas seguintes.

---

## Próximos Passos e Prioridades

- **Design de Interface** — Iniciar o desenvolvimento dos mockups para o dashboard.
- **Desenvolvimento Técnico** — Coordenar com o TechLab a parte técnica e o protótipo inicial do sensor, definindo componentes e arquitetura de hardware.

# Relatório Semanal 2

## 1. Validação da Base de Dados

### 1.1 Mapa de Navegação

A plataforma Águas Alerta está organizada em duas áreas principais: o dashboard público, acessível a qualquer utilizador, e o backoffice de administração, restrito a utilizadores autenticados.

```
Águas Alerta
│
├── Dashboard Público  →  index.html
│   ├── Mapa SIG com estações georreferenciadas (Leaflet.js)
│   │   └── Clique numa estação
│   │       ├── Nível atual da água (metros)
│   │       ├── Caudal atual (L/min)
│   │       └── Estado: 🟢 Normal | 🟠 Atenção | 🔴 Alerta
│   ├── Cards de resumo (nível máximo, caudal, alertas ativos)
│   ├── Barras de ocupação dos limites de segurança por estação
│   ├── Banner de alerta ativo (aparece automaticamente)
│   └── Tabela das últimas 30 leituras dos sensores
│
└── Backoffice  →  backoffice/index.php
    ├── Dashboard estatístico dinâmico
    ├── Gestão de estações (adicionar / editar / desativar)
    ├── Histórico de alertas
    │   └── Detalhe → notificações enviadas às localidades
    ├── Gestão de localidades e contactos
    └── Gestão de utilizadores e permissões
```

## 2. Validação do Sistema

O sistema foi implementado e testado localmente com XAMPP (Apache + PHP) e MySQL Workbench. Demonstra o ciclo completo: os dados são gerados pelo simulador, guardados na base de dados pelo servidor PHP, e apresentados na página HTML em tempo real.

### 2.1 Origem dos Dados

Os dados têm origem num dispositivo **Arduino** equipado com três sensores:

| Sensor | Modelo | Mede |
|--------|--------|------|
| Nível da água | JSN-SR04T (ultrassónico impermeável) | Distância à superfície → nível em metros |
| Caudal | YF-S201B (turbina) | Pulsos por rotação → L/min |
| Temperatura | DS18B20 (sonda impermeável) | Temperatura da água em °C |

Para demonstração sem hardware físico, foi criado um **simulador em PHP** (`simulador.php`) que gera leituras automáticas com variação aleatória controlada, replicando o comportamento real de um rio — incluindo situações de alerta (1 em cada 4 leituras ultrapassa o limite de segurança).

```php
// simulador.php — gera dados como se fosse o Arduino
foreach ($estacoes as $est) {
    $alerta = rand(1, 4) === 1;   

    if ($alerta) {
        // Ultrapassa o limite — simula cheia
        $nivel  = round($est["nivel_max_seguranca"]  * (1 + rand(10,40)/100), 2);
        $caudal = round($est["caudal_max_seguranca"] * (1 + rand(10,40)/100), 1);
    } else {
        // Valor normal (30% a 85% do limite)
        $pct    = rand(30, 85) / 100;
        $nivel  = round($est["nivel_max_seguranca"]  * $pct, 2);
        $caudal = round($est["caudal_max_seguranca"] * $pct, 1);
    }

    $temperatura = round(rand(110, 170) / 10, 1);

    // Envia para o servidor via stored procedure
    $stmt = $pdo->prepare("CALL sp_registar_leitura(?, ?, ?, ?)");
    $stmt->execute([$est["id_estacao"], $nivel, $caudal, $temperatura]);
}
```

### 2.2 Servidor — Backend (PHP + MySQL)

O servidor foi implementado em **PHP com XAMPP** e base de dados **MySQL** (MySQL Workbench). Foram criados os seguintes ficheiros:

```
vir/
├── config/
│   └── db.php                  ← ligação PDO ao MySQL
├── api/
│   ├── leituras.php            ← GET → devolve últimas 30 leituras em JSON
│   ├── alertas.php             ← GET → devolve alertas ativos e histórico em JSON
│   └── estacoes.php            ← GET → devolve estações com última leitura em JSON
└── simulador.php               ← gera e insere dados simulados na BD
```

**Como o servidor recebe e guarda os dados:**

O `simulador.php` (ou o Arduino real) chama a stored procedure `sp_registar_leitura` diretamente na base de dados. Esta procedure:
1. Insere a leitura na tabela `leituras`
2. Verifica se o nível ou caudal ultrapassa os limites da estação
3. Se sim, cria automaticamente um registo na tabela `alertas`
4. Se os valores voltarem ao normal, resolve os alertas ativos

```sql
-- Stored procedure criada na base de dados vir_db
CALL sp_registar_leitura(
    1,      -- id da estação
    5.80,   -- nível da água (metros) — acima do limite de 5.0m
    162.0,  -- caudal (L/min) — acima do limite de 150 L/min
    13.7    -- temperatura (°C)
);
-- Resultado: leitura guardada + alerta criado automaticamente
```

**Como o servidor envia os dados para o HTML:**

Cada endpoint da API devolve os dados em formato JSON quando chamado pelo frontend:

```php
// api/leituras.php — chamado pelo JavaScript do dashboard
header("Content-Type: application/json");
$stmt = $pdo->query("
    SELECT l.*, e.nome AS estacao,
           e.nivel_max_seguranca, e.caudal_max_seguranca
    FROM leituras l
    JOIN estacoes e ON e.id_estacao = l.id_estacao
    ORDER BY l.timestamp DESC LIMIT 30
");
echo json_encode($stmt->fetchAll());
```

**Base de dados criada — tabelas principais:**

| Tabela | Função |
|--------|--------|
| `estacoes` | Dispositivos Arduino instalados no rio (coordenadas GPS, limites) |
| `leituras` | Cada medição dos sensores (nível, caudal, temperatura, timestamp) |
| `alertas` | Eventos de alerta gerados automaticamente quando limite é excedido |
| `localidades` | Populações e entidades a notificar por cada estação |
| `notificacoes` | Histórico de mensagens enviadas (email, SMS, sirene) |

### 2.3 Página HTML — Frontend

A página `index.html` foi desenvolvida em **HTML5 + CSS3 + JavaScript**, sem frameworks externas (exceto Leaflet.js para o mapa). Ao carregar, faz pedidos simultâneos aos três endpoints da API e apresenta os dados visualmente. Atualiza automaticamente a cada 10 segundos.

```javascript
// dashboard — lê dados do servidor e mostra no ecrã
async function atualizar() {
    const [leituras, alertaResp, estacoes] = await Promise.all([
        fetch('api/leituras.php').then(r => r.json()),
        fetch('api/alertas.php').then(r => r.json()),
        fetch('api/estacoes.php').then(r => r.json()),
    ]);

    // Atualiza cards, barras, mapa e tabela com os dados recebidos
    renderCards(estacoes, alertaResp);
    renderBarras(estacoes);
    renderMapa(estacoes);
    renderTabela(leituras);
}

atualizar();
setInterval(atualizar, 10000); 
```

**O que é apresentado no ecrã:**

- **Cards de resumo** — nível máximo atual, caudal máximo e número de alertas ativos (ficam vermelhos quando há alerta)
- **Mapa SIG** — marcadores georreferenciados de cada estação com cor por nível de risco (verde / laranja / vermelho), usando Leaflet.js + OpenStreetMap
- **Gráficos de barras** — percentagem de ocupação do limite de segurança por estação, em tempo real
- **Banner de alerta** — aparece automaticamente quando existe pelo menos um alerta ativo, com o nome das estações afetadas
- **Tabela de leituras** — últimas 30 medições com badge verde (Normal) ou vermelho (Alerta)
- **Log do simulador** — registo em tempo real de cada leitura simulada, mostrando o fluxo completo de dados
