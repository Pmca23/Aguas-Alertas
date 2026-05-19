# Relatório Individual 1 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Durante esta fase inicial do projeto, comecei a preparação e estudo dos sensores que serão utilizados no sistema de monitorização ambiental.

O principal foco foi compreender o funcionamento do ESP32 e a integração entre hardware e software. Foram realizados testes iniciais com diferentes sensores e com a comunicação Serial através do Arduino IDE.

### Atividades realizadas
- Configuração inicial do ESP32;
- Instalação do Arduino IDE e bibliotecas necessárias;
- Testes básicos de comunicação Serial;
- Estudo do sensor de chuva;
- Estudo do sensor de temperatura DS18B20;
- Verificação da alimentação e pinagem dos sensores.

## Dificuldades Encontradas
- Problemas na deteção da porta COM do ESP32;
- Necessidade de compreender melhor a ligação dos GPIO;
- Configuração inicial das bibliotecas do Arduino IDE.

## Contributo para o Projeto
Contribuí principalmente na preparação e testes iniciais dos sensores físicos que irão fornecer dados ao sistema de monitorização.

---

# Relatório Individual 2 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Nesta fase continuei os testes relacionados com o sensor de chuva ligado ao ESP32.

Foram realizados testes utilizando:
- Saída digital (DO);
- Saída analógica (AO).

Também foi desenvolvido código para leitura de valores analógicos e deteção de chuva através do Serial Monitor.

### Atividades realizadas
- Ligação do sensor de chuva ao ESP32;
- Testes de leitura analógica;
- Ajuste da sensibilidade do sensor;
- Desenvolvimento de código para deteção de chuva;
- Testes práticos com água.

## Dificuldades Encontradas
- Leituras incorretas mesmo sem água;
- Necessidade de calibração do sensor;
- Diferenças entre funcionamento digital e analógico.

## Contributo para o Projeto
Fiquei responsável pela validação do funcionamento do sensor de chuva e pela lógica inicial de deteção ambiental.

---

# Relatório Individual 3 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Nesta fase foi iniciado o trabalho com o sensor de temperatura DS18B20 utilizando o ESP32.

Foram realizados vários testes de leitura de temperatura em tempo real e configuração das bibliotecas necessárias.

### Atividades realizadas
- Instalação das bibliotecas OneWire e DallasTemperature;
- Configuração do sensor DS18B20;
- Testes de leitura de temperatura;
- Verificação da estabilidade das leituras;
- Testes de ligação utilizando diferentes GPIO.

## Dificuldades Encontradas
- Problemas de compilação no Arduino IDE;
- Configuração incorreta de GPIO;
- Dificuldades na deteção inicial do sensor;
- Necessidade de utilização de resistor pull-up.

## Contributo para o Projeto
Contribuí no desenvolvimento da componente responsável pela recolha de temperatura ambiental.

---

# Relatório Individual 4 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Durante esta fase foi iniciada a integração entre os sensores e a base de dados do projeto.

O objetivo principal foi garantir que os dados recolhidos pelos sensores fossem corretamente enviados para o sistema.

### Atividades realizadas
- Testes de envio de dados;
- Organização da estrutura de comunicação;
- Verificação do fluxo de dados;
- Testes de integração entre hardware e backend;
- Apoio na definição dos dados apresentados no dashboard.

## Dificuldades Encontradas
- Sincronização entre sensores e backend;
- Problemas de estabilidade em alguns testes;
- Ajuste do formato dos dados enviados.

## Contributo para o Projeto
Contribuí na integração entre hardware e software, permitindo a preparação do sistema de monitorização em tempo real.

---

# Relatório Individual 5 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Nesta etapa foram realizados testes mais completos ao sistema integrado.

Os sensores foram testados em conjunto para validar o correto funcionamento da recolha de dados.

### Atividades realizadas
- Simulação de condições de chuva;
- Testes contínuos dos sensores;
- Verificação das leituras em tempo real;
- Ajustes de precisão dos sensores;
- Testes gerais do sistema.

## Dificuldades Encontradas
- Oscilações em alguns valores analógicos;
- Necessidade de melhorar estabilidade das leituras;
- Ajustes de alimentação dos sensores.

## Contributo para o Projeto
Ajudei a garantir que os sensores produzem dados consistentes para o dashboard de monitorização.

---

# Relatório Individual 6 — Paulo Alberto

## Projeto
Águas Alertas — Sistema de Monitorização do Nível das Águas dos Rios

## Trabalho Desenvolvido
Na fase final participei nos testes globais e validação do projeto.

O foco principal foi garantir a correta comunicação entre sensores, base de dados e dashboard web.

### Atividades realizadas
- Testes finais do sistema;
- Verificação da comunicação entre componentes;
- Ajustes finais dos sensores;
- Apoio na documentação técnica;
- Preparação para apresentação do projeto.

## Dificuldades Encontradas
- Necessidade de otimizar parâmetros dos sensores;
- Garantir estabilidade contínua das leituras;
- Ajustes finais de integração.

## Contributo para o Projeto
O meu principal contributo foi na área de sensores e monitorização física, garantindo a recolha de dados ambientais para o sistema de alerta.
