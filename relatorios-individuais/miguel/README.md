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

### Desenvolvimento de Ideias e Conceito

Nesta fase o trabalho centrou-se na consolidação das ideias para o projeto, partindo dos resultados da investigação inicial. Foi feita uma análise aprofundada dos requisitos funcionais da plataforma, identificando os principais fluxos de utilização para cada perfil de utilizador — público, técnico e administrador.

Foram exploradas diferentes abordagens para a arquitetura de informação do site, debatendo a melhor forma de apresentar dados em tempo real de forma clara e acessível a qualquer utilizador, independentemente do seu nível técnico.

### Investigação e UX Research

- Desenvolvimento de personas representativas dos diferentes perfis de utilizadores da plataforma
- Elaboração da jornada do utilizador (user journey) para cada perfil, identificando pontos de contacto, ações, emoções e oportunidades de melhoria
- Pesquisa de utilizadores para compreender necessidades, comportamentos e expectativas do público-alvo
- Ligação entre insights recolhidos na pesquisa, identificando padrões de comportamento e prioridades de design

### Definição da Identidade Visual

Foi estabelecido o sistema de design da plataforma, definindo os elementos visuais que seriam usados de forma consistente em todas as páginas:

- Paleta de cores assente num gradiente azul profundo, complementado pelo sistema semafórico de risco: verde (seguro), laranja (aviso) e vermelho (crítico)
- Tipografia: Montserrat para títulos e Roboto para texto de interface
- Estilo glassmorphism para elementos de autenticação e cards
- Definição dos componentes reutilizáveis: cards de dados, barras de nível, banners de alerta e badges de estado

### Reflexão Crítica

A fase de desenvolvimento de ideias e investigação foi essencial para garantir que as decisões de design tomadas nas fases seguintes fossem fundamentadas em necessidades reais dos utilizadores e não em suposições. O trabalho produzido nesta fase serviu de base para toda a prototipagem e desenvolvimento subsequentes.

### Próximos Passos e Prioridades

Avançar para a produção de wireframes e mockups de alta fidelidade com base nas decisões tomadas nesta fase.

---

## Relatório 3

**Relatório Individual – Miguel Croca**

### Produção de Wireframes e Mockups

Nesta fase foram produzidos wireframes e mockups de alta fidelidade para todas as páginas da plataforma Águas Alerta, servindo como guia visual para o desenvolvimento frontend.

### Wireframes Produzidos

Foram criados wireframes de alta fidelidade em HTML para as cinco páginas da plataforma, reproduzindo fielmente o design system definido na fase anterior:

- **Wireframe da Página Inicial** — estrutura com cabeçalho, logótipo, barra de pesquisa por zona e mapa interativo
- **Wireframe do Login de Administrador** — card centralizado com glassmorphism, campos de autenticação e logótipo da marca
- **Wireframe do Dashboard Público** — barras de nível com sistema de cores de risco, seletor de estação, gráfico histórico e separador de alertas
- **Wireframe do Painel de Administrador** — interface com tabs para gestão de utilizadores e estatísticas globais
- **Wireframe do Painel Técnico** — interface com tabs para gestão de alertas, registo de observações e histórico

### Mockups das Interfaces

Os mockups foram desenvolvidos com foco na clareza e na rapidez de leitura, respondendo diretamente aos insights recolhidos na fase de investigação:

- Página inicial com barra de pesquisa por zona para acesso imediato à informação relevante
- Dashboard com sistema de cores verde/laranja/vermelho para comunicar níveis de risco de forma intuitiva
- Painéis de administração e técnico com interfaces distintas e adaptadas às responsabilidades de cada perfil
- Consistência visual garantida em todos os ecrãs, com alinhamento com as necessidades dos utilizadores identificadas nas personas

### Diagrama de Casos de Uso

Foi produzido um diagrama de casos de uso para documentação técnica do projeto, contemplando:

- Ator Utilizador Público: consultar dashboard, ver níveis dos rios, ver alertas ativos, pesquisar por zona
- Ator Técnico: registar observações, alterar nível crítico, ver histórico, gerir alertas
- Ator Administrador: gerir utilizadores, criar técnicos, consultar estatísticas globais
- Fronteira do sistema claramente delimitada com identificação de todas as interações

### Reflexão Crítica

A produção de wireframes e mockups antes do início do desenvolvimento permitiu reduzir o número de iterações necessárias durante a implementação e assegurou que toda a equipa partilhava a mesma visão sobre o produto final.

### Próximos Passos e Prioridades

Iniciar o desenvolvimento frontend com base nos wireframes produzidos, começando pela página inicial e pelo sistema de login.

---

## Relatório 4

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

## Relatório 5

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
