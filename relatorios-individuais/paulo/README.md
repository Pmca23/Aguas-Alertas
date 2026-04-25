# Águas Alertas

## Dashboard de Monitorização do Nível das Águas dos Rios

*Relatório Individual — Fase Inicial do Projeto (#2)*

---

## 1. Detalhe das Tarefas Individuais em Curso

Nesta fase inicial do projeto, o foco principal tem sido a definição do conceito, levantamento de requisitos e planeamento da arquitetura do sistema. As tarefas realizadas durante esta semana foram as seguintes:

### 1.1 Definição do Conceito e Objetivos do Projeto

Foi definido o conceito central do projeto: uma plataforma web estilo dashboard para monitorização em tempo real do nível das águas dos rios, com foco na prevenção e aviso de cheias. O sistema visa disponibilizar dados de forma clara e acessível a autoridades, técnicos de proteção civil e população em geral.

### 1.2 Levantamento de Requisitos Funcionais

- Visualização do nível da água por rio/estação de medição em tempo real  
- Sistema de alertas por níveis (verde, amarelo, laranja, vermelho)  
- Mapa interativo com marcadores por estação hidrométrica  
- Histórico de medições e gráficos de tendência  
- Painel de administração para gestão de sensores e estações  
- Notificações automáticas por e-mail/SMS em caso de alerta  

### 1.3 Arquitetura Técnica Inicial

Foi esboçada a arquitetura técnica do projeto, que inclui os seguintes componentes:

- **Frontend:** Dashboard web responsivo (HTML/CSS/JS ou framework como React/Vue)  
- **Backend:** API REST para receber e servir dados das estações de medição  
- **Base de dados:** Armazenamento de leituras históricas e configurações  
- **Integração:** Ligação a fontes de dados reais (ex.: SNIRH — Sistema Nacional de Informação de Recursos Hídricos)  

### 1.4 Estado Atual das Atividades

Estado de progresso das principais componentes do projeto:

- Definição do tema e objetivos — **Concluído**  
- Levantamento de requisitos iniciais — **Concluído**  
- Pesquisa de APIs e fontes de dados hidrométricos — **Em curso**  
- Prototipagem do dashboard (wireframes) — **Por iniciar**  
- Configuração do repositório GitHub e estrutura do projeto — **Por iniciar**  

---

## 2. Reflexão Crítica Individual

### 2.1 Resultados Obtidos vs. Objetivos Iniciais

Esta fase inicial correu de forma positiva. Os objetivos propostos para esta semana — nomeadamente a conceção do projeto e o levantamento de requisitos — foram cumpridos. A ideia do projeto revelou-se pertinente e com impacto social real, o que motivou ainda mais o investimento nesta fase de planeamento.

No entanto, o âmbito do projeto acabou por ser ligeiramente mais alargado do que o inicialmente previsto, uma vez que a integração com fontes de dados reais (como o SNIRH) introduz uma camada de complexidade adicional que não tinha sido inicialmente considerada.

### 2.2 Dificuldades Encontradas e Estratégias de Resolução

As principais dificuldades identificadas nesta fase foram:

- **Acesso a dados em tempo real:**  
  A principal dificuldade prende-se com a disponibilidade e formato de dados hidrométricos em Portugal.  
  **Estratégia:** investigar a API do SNIRH e avaliar alternativas como dados simulados para a fase de desenvolvimento.

- **Definição do sistema de alertas:**  
  Estabelecer os limiares de alerta (níveis verde/amarelo/laranja/vermelho) requer investigação técnica adicional.  
  **Estratégia:** consultar documentação da ANPC (Autoridade Nacional de Emergência e Proteção Civil).

- **Complexidade da interface:**  
  Criar um dashboard informativo mas simples e intuitivo é um desafio de design.  
  **Estratégia:** começar com wireframes simples e validar com utilizadores antes de avançar para o desenvolvimento.

### 2.3 Tarefas em Atraso

Não existem tarefas em atraso neste momento, dado tratar-se de um relatório da fase inicial. Contudo, a pesquisa de APIs de dados hidrométricos está a revelar-se mais demorada do que previsto, o que poderá condicionar o início da prototipagem na próxima semana.

### 2.4 Outros Aspetos Relevantes

O projeto **"Águas Alertas"** tem potencial de impacto real na sociedade, especialmente numa época em que os eventos de cheias são cada vez mais frequentes em Portugal. A sua relevância social é um fator motivador importante para o desenvolvimento do trabalho.

Nos próximos passos, será fundamental definir claramente o **MVP (Minimum Viable Product)** do projeto, para garantir que o desenvolvimento se mantém focado e dentro do prazo estabelecido. A configuração do repositório GitHub e a organização do código desde o início serão também prioritárias.

---

*Projeto de Desenvolvimento Web — Relatório Individual #2*
