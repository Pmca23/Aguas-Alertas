#include <WiFi.h>
#include <HTTPClient.h>

#include <OneWire.h>
#include <DallasTemperature.h>

// WIFI
const char* ssid = "nome da internet usada";
const char* password = "password do wifi";

// API BACKEND
String servidor =
"http://192.168.1.65/vir/backend/api/iot/arduino_leitura.php";

// SENSOR DISTÂNCIA
#define TRIG_PIN 4
#define ECHO_PIN 2

// SENSOR TEMPERATURA DS18B20
#define TEMP_PIN 19

OneWire oneWire(TEMP_PIN);
DallasTemperature DS18B20(&oneWire);

// SENSOR CHUVA
#define CHUVA_PIN 34

int threshold = 2000;



// altura máxima até fundo
float alturaMaxima = 100.0;





void setup() {

  Serial.begin(115200);

  //WIFI
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {

    delay(1000);
    Serial.println("Ligar ao WiFi...");
  }

  Serial.println("WiFi ligado");

  // DISTÂNCIA
  pinMode(TRIG_PIN, OUTPUT);
  pinMode(ECHO_PIN, INPUT);

  // TEMPERATURA 
  DS18B20.begin();

  Serial.println("Sistema iniciado...");
}

// LER DISTÂNCIA
float lerDistanciaCM() {

  digitalWrite(TRIG_PIN, LOW);
  delayMicroseconds(2);

  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);

  digitalWrite(TRIG_PIN, LOW);

  long duracao = pulseIn(ECHO_PIN, HIGH);

  float distancia = duracao / 58.2;

  return distancia;
}



// LOOP
void loop() {

  // DISTÂNCIA
  float distancia = lerDistanciaCM();

  // converter distância em nível água
  float nivelAgua = alturaMaxima - distancia;

  if (nivelAgua < 0) {
    nivelAgua = 0;
  }

  
  // TEMPERATURA
  DS18B20.requestTemperatures();

  float tempC =
  DS18B20.getTempCByIndex(0);


  // CHUVA
  int valorChuva = analogRead(CHUVA_PIN);

  int chuva = 0;

  if (valorChuva < threshold) {
    chuva = 1;
  }


  // SERIAL
  Serial.println("------ LEITURAS ------");

  Serial.print("Nível Água: ");
  Serial.print(nivelAgua);
  Serial.println(" cm");

  if (tempC == DEVICE_DISCONNECTED_C) {

    Serial.println(
      "Temperatura: sensor não encontrado"
    );

  } else {

    Serial.print("Temperatura: ");
    Serial.print(tempC);
    Serial.println(" °C");
  }

  Serial.print("Sensor chuva: ");
  Serial.print(valorChuva);
  Serial.print(" -> ");

  if (chuva) {

    Serial.println("Está a chover");

  } else {

    Serial.println("Não está a chover");
  }


  // ENVIAR PARA BACKEND
  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    http.begin(servidor);

    http.addHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );

    String dados =

      "api_key=vir_estação1" +

      String("&id_estacao=1") +

      "&nivel=" + String(nivelAgua) +

      "&temperatura=" + String(tempC) +

      "&chuva=" + String(chuva);

    int response = http.POST(dados);

    Serial.print("HTTP Response: ");

    Serial.println(response);

    String resposta =
    http.getString();

    Serial.println(resposta);

    http.end();
  }

  Serial.println("----------------------\n");

  delay(15000);
}
