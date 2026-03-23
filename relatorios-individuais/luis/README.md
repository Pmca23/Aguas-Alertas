1. Detalhe das Tarefas em Curso
1.1 Definição do Conceito do Projeto
Estruturação da ideia base do sistema de sensores para medição contínua do nível da água em rios, com o objetivo de prevenção e alerta antecipado de cheias.
1.2 Análise Técnica Inicial
Discussão sobre possíveis métodos de medição:
Sensor submersível de pressão
Tubo de medição vertical com sensores distribuídos
Sistema de medição contínua de nível
Reflexão sobre a resistência do equipamento a condições extremas, como corrente forte, detritos e intempéries.
1.3 Estrutura da Plataforma Web
Planeamento inicial das funcionalidades da página web, que permitirá à população, bombeiros e entidades competentes acompanhar os níveis da água em tempo real.
2. Reflexão Crítica
2.1 Estado do Projeto
O projeto encontra-se dentro do cronograma previsto.
2.2 Avaliação Técnica
A fase atual foi essencial para consolidar a viabilidade técnica e funcional da solução proposta.
A medição contínua revelou-se particularmente relevante, pois permite maior precisão e melhor capacidade de previsão comparativamente a medições pontuais.
Foi também considerada a necessidade de robustez do sistema, tendo em conta os desafios do ambiente fluvial ao nível da durabilidade e manutenção.
3. Próximos Passos e Prioridades
3.1 Definição Técnica do Sensor
Selecionar o tipo de sensor mais adequado (ex: sensor de pressão submersível) e definir os materiais de proteção.
3.2 Protótipo Inicial
Esquematizar um modelo técnico com corte estrutural do sensor e definir os componentes eletrónicos necessários.
3.3 Desenvolvimento do Dashboard Web
Criar os primeiros mockups da interface, incluindo:
Visualização gráfica do nível da água
Alertas automáticos
Histórico de medições

2º Relatório

1. Validação da Base de Dados
1.1 Mapa de Navegação
A plataforma Águas Alerta encontra-se organizada em duas áreas distintas:
um dashboard público, acessível a qualquer utilizador
um backoffice administrativo, reservado a utilizadores autenticados
A estrutura de navegação é a seguinte:
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
2. Validação do Sistema
O sistema foi desenvolvido e testado em ambiente local, permitindo validar todo o fluxo de funcionamento da aplicação.
Os dados são gerados automaticamente por um simulador, armazenados na base de dados e posteriormente apresentados no dashboard em tempo real.
2.1 Origem dos Dados
As medições têm como base um dispositivo Arduino equipado com diferentes sensores, responsáveis por recolher informação essencial sobre o estado do rio:
Sensor	Modelo	Função
Nível da água	JSN-SR04T (ultrassónico)	Mede a distância à superfície, convertida em metros
Caudal	YF-S201B (turbina)	Calcula o fluxo em L/min através de pulsos
Temperatura	DS18B20	Mede a temperatura da água em °C
Para efeitos de demonstração, foi utilizado um simulador que gera automaticamente valores com variação controlada, reproduzindo situações reais — incluindo cenários de alerta quando os limites de segurança são ultrapassados.
2.2 Estrutura de Dados
A base de dados foi organizada de forma a suportar o funcionamento completo da aplicação, sendo composta pelas seguintes tabelas principais:
Tabela	Descrição
estacoes	Informação das estações (localização e limites de segurança)
leituras	Registo de medições dos sensores ao longo do tempo
alertas	Eventos gerados quando os valores ultrapassam os limites
localidades	Entidades associadas a cada estação
notificacoes	Histórico de comunicações enviadas
2.3 Frontend — Interface do Utilizador
O frontend foi devidamente estruturado, servindo como base visual para a implementação da aplicação.
Foi desenvolvido com HTML5, CSS3 e JavaScript, utilizando apenas a biblioteca Leaflet.js para a componente de mapa.
Mais do que uma interface final, esta página funciona também como um modelo visual (wireframe funcional) que orienta o desenvolvimento e valida a forma como os dados são apresentados ao utilizador.
A página principal organiza a informação de forma clara e intuitiva, permitindo acompanhar o estado das estações em tempo real.
Elementos apresentados:
Cards de resumo
Apresentam indicadores gerais, como o nível máximo registado, o caudal e o número de alertas ativos, com destaque visual em situações críticas.
Mapa SIG interativo
Mostra as estações georreferenciadas com cores associadas ao nível de risco (verde, laranja e vermelho), permitindo interação direta com cada ponto.
Barras de progresso
Indicam a percentagem de ocupação dos limites de segurança por estação, facilitando a perceção do risco.
Banner de alerta
Surge automaticamente quando existem situações críticas, destacando as estações afetadas.
Tabela de leituras
Apresenta as últimas medições registadas, com identificação visual do estado (normal ou alerta).
Considerações Finais
O frontend desenvolvido permite validar a organização da informação e a experiência do utilizador, funcionando como uma representação clara do sistema final.
Esta abordagem facilita a evolução do projeto, garantindo que a interface está alinhada com os objetivos da aplicação antes da integração completa com os restantes componentes.
