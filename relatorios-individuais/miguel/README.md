# Relatórios Individuais — Miguel Croca

---

## Relatório 1

**Relatório Individual – Miguel Croca**

### Detalhe das Tarefas em Curso

Durante esta semana estive focado no planeamento técnico do projeto V.I.R., cujo objetivo é criar um sistema de monitorização do nível dos rios com alerta sonoro imediato em caso de risco de cheia.

Comecei por aprofundar o estudo do problema identificado que se resume à falta de monitorização em tempo real em rios de pequena dimensão.

De seguida, analisei soluções já existentes, como estações hidrométricas tradicionais e sensores IoT. Isto permitiu-me perceber as suas limitações e reforçar a importância de combinar a recolha de dados com um sistema de aviso sonoro local.

### Planeamento Estratégico

Nesta fase foquei-me no plano da base de dados para registo diário das medições.

### Reflexão Crítica

De forma geral, considero que o trabalho desenvolvido está de acordo com os objetivos iniciais. O grupo conseguiu estruturar uma solução tecnicamente viável e com potencial impacto real na proteção de pessoas e bens.

### Próximos Passos e Prioridades

Iniciar o desenvolvimento da base de dados para registo diário das medições.

### Desenvolvimento Técnico

Até ao momento não existem atrasos significativos, embora a fase de testes possa exigir ajustes adicionais.

Para concluir, considero que o trabalho está a evoluir de forma positiva. Ainda existem desafios técnicos a ultrapassar, mas o projeto apresenta bases sólidas e um impacto social relevante, especialmente para populações em zonas de risco.

---

## Relatório 2

**Relatório Individual – Miguel Croca**

### Página de Login

Criada de raiz com design consistente com a identidade visual do projeto. Funcionalidades implementadas:

- Formulário de autenticação com campos de email e palavra-passe
- Ícone de olho para alternância de visibilidade da palavra-passe
- Spinner de loading durante a validação das credenciais
- Animação de shake no card em caso de credenciais incorretas
- Overlay de sucesso antes do redirecionamento
- Substituição do ícone de escudo pela `logosemtexto.png` da marca, com dimensão aumentada para 90px
- Integração com a API REST em PHP: envio de credenciais para o endpoint de autenticação e receção do token JWT
- Deteção automática do role devolvido pela API (`admin` ou `tecnico`) e redirecionamento para o painel correspondente
- Armazenamento do token JWT no `sessionStorage` para uso nas páginas privadas

### Painel de Administrador e Técnico

Página de acesso restrito ao perfil `admin`, com verificação de sessão JWT ao carregar. Funcionalidades:

- Guard de autenticação: redireciona para `login.html` se não existir sessão válida
- Listagem de utilizadores técnicos registados, consumida a partir da API privada
- Formulário de criação de novos técnicos com envio para o endpoint correspondente
- Funcionalidade de eliminação de técnicos
- Dashboard geral com estatísticas globais do sistema
- Interface com separadores (tabs) para navegação entre funcionalidades
- Guard de autenticação com redirecionamento automático
- Consulta de dados das estações e histórico por período
- Alteração do nível crítico de alerta por estação
- Registo de observações com associação à estação
- Consulta de alertas ativos e gestão dos mesmos
- Consulta de emails enviados pelo sistema

---

## Relatório 3

**Relatório Individual – Miguel Croca**

### Integração do Backend e Base de Dados

Após receção dos ficheiros do backend desenvolvidos pelo colega de equipa, foi realizada a integração completa entre o frontend e a API REST em PHP:

- Configuração do XAMPP como servidor local de desenvolvimento (Apache + MySQL)
- Identificação da estrutura da base de dados `vir_db` e confirmação das credenciais no ficheiro `api/config/db.php`
- Atualização de todos os endpoints no frontend para corresponder à estrutura da API
- Implementação de pedidos fetch com `async/await` em todas as páginas que consomem dados
- Adição do header `Authorization: Bearer {token}` em todos os pedidos a rotas privadas
- Resolução de erros de integração identificados durante os testes (token inválido, URLs incorretos, CORS)
- Criação de alertas e leituras de teste na base de dados via phpMyAdmin para validação das interfaces

### Textos e Apresentações

- Descrição do sistema de autenticação JWT e separação de perfis
- Texto sobre soluções técnicas implementadas (API REST, base de dados relacional, consumo assíncrono, sistema de cores dinâmico)
- Texto sobre o diagrama de casos de uso e os três atores do sistema
- Texto sobre os mockups e o processo de design das interfaces
- Texto sobre o design system e UI assets da plataforma
- Texto sobre previsões de desenvolvimento futuro da aplicação
- Texto sobre desenvolvimentos futuros do mapa interativo (barragens, zonas de risco, dados meteorológicos)

### Diagrama de Casos de Uso

Foi feito um diagrama de casos de uso para documentação do projeto, contemplando:

- Ator Utilizador Público: consultar dashboard, ver níveis dos rios, ver alertas ativos, pesquisar por zona
- Ator Técnico: registar observações, alterar nível crítico, ver histórico, gerir alertas
- Ator Administrador: gerir utilizadores, criar técnicos, consultar estatísticas globais
- Fronteira do sistema claramente delimitada com identificação de todas as interações

 

Miguel Croca, 20240408 

 

 
