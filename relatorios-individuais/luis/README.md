# 1º Relatório. Detalhe das Tarefas em Curso

## 1.1 Definição do Conceito do Projeto
Estruturação da ideia base do sistema de sensores para medição contínua do nível da água em rios, com o objetivo de prevenção e alerta antecipado de cheias.

## 1.2 Análise Técnica Inicial
Discussão sobre possíveis métodos de medição:

- Sensor submersível de pressão  
- Tubo de medição vertical com sensores distribuídos  
- Sistema de medição contínua de nível  

Reflexão sobre a resistência do equipamento a condições extremas, como corrente forte, detritos e intempéries.

## 1.3 Estrutura da Plataforma Web
Planeamento inicial das funcionalidades da página web, que permitirá à população, bombeiros e entidades competentes acompanhar os níveis da água em tempo real.

---

# 2. Reflexão Crítica

## 2.1 Estado do Projeto
O projeto encontra-se dentro do cronograma previsto.

## 2.2 Avaliação Técnica
A fase atual foi essencial para consolidar a viabilidade técnica e funcional da solução proposta.

A medição contínua revelou-se particularmente relevante, pois permite maior precisão e melhor capacidade de previsão comparativamente a medições pontuais.

Foi também considerada a necessidade de robustez do sistema, tendo em conta os desafios do ambiente fluvial ao nível da durabilidade e manutenção.

---

# 3. Próximos Passos e Prioridades

## 3.1 Definição Técnica do Sensor
Selecionar o tipo de sensor mais adequado (ex: sensor de pressão submersível) e definir os materiais de proteção.

## 3.2 Protótipo Inicial
Esquematizar um modelo técnico com corte estrutural do sensor e definir os componentes eletrónicos necessários.

## 3.3 Desenvolvimento do Dashboard Web
Criar os primeiros mockups da interface, incluindo:

- Visualização gráfica do nível da água  
- Alertas automáticos  
- Histórico de medições  

---

# 2º Relatório

# 1. Validação da Base de Dados

## 1.1 Mapa de Navegação

A plataforma **Águas Alerta** encontra-se organizada em duas áreas distintas:

- Dashboard público (acesso livre)  
- Backoffice administrativo (acesso restrito)  

```text
Águas Alerta
│
├── Dashboard Público  →  index.html
│   ├── Mapa SIG com estações georreferenciadas (Leaflet.js)
│   │   └── Clique numa estação
│   │       ├── Nível atual da água (metros)
│   │       ├── Caudal atual (L/min)
│   │       └── Estado: 🟢 Normal | 🟠 Atenção | 🔴 Alerta
│   ├── Cards de resumo
│   ├── Barras de ocupação
│   ├── Banner de alerta
│   └── Tabela de leituras
│
└── Backoffice  →  backoffice/index.php
```
2.3 Frontend — Interface do Utilizador
O frontend foi estruturado como base visual da aplicação.
Desenvolvido com:
HTML5
CSS3
JavaScript
Leaflet.js
Funciona como um modelo visual (wireframe funcional) para guiar o desenvolvimento.
Elementos apresentados
Cards de resumo
Mapa interativo
Barras de progresso
Banner de alerta
Tabela de leituras
Considerações Finais
O frontend permite validar a organização da informação e a experiência do utilizador, funcionando como uma representação clara do sistema final.
Facilita também a evolução do projeto antes da integração completa.
# 3º Relatório

## 1. Evolução do Projeto

### 1.1 Aquisição de Sensores

Durante esta fase do projeto, foi realizada a aquisição dos sensores necessários para o sistema de monitoramento dos rios.

Os sensores adquiridos permitem medir:
- Nível da água
- Caudal
- Temperatura
- Percepitação 

Esta etapa foi essencial para avançar da componente teórica para a implementação prática do sistema.

---

### 1.2 Contacto com o TechLab

Foi estabelecido contacto com o TechLab com o objetivo de:
- Obter orientação técnica sobre os sensores
- Validar a escolha dos componentes
- Esclarecer dúvidas relacionadas com instalação e funcionamento

O feedback recebido ajudou a garantir que os sensores escolhidos são adequados para o contexto do projeto.

---

### 1.3 Início da Montagem

Após a aquisição dos sensores, iniciou-se a fase de montagem.

Nesta fase:
- Foram preparados os primeiros componentes
- Iniciou-se a integração dos sensores com o sistema
- Foram realizados testes iniciais de funcionamento

A montagem encontra-se ainda em progresso, sendo esta uma etapa fundamental para a futura recolha de dados reais.

---

## 2. Estado Atual do Projeto

Atualmente, o projeto encontra-se numa fase de transição entre:
- Planeamento
- Implementação prática
