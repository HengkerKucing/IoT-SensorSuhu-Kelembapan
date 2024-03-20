#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include "DHT.h"

#define DHTPIN 5
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);
WiFiClient wifiClient;

// Variabel untuk konfigurasi WiFi
const char* ssid = "25";
const char* password = "wmtk0025";

// Server tempat script PHP berada
const char* server = "http://luqman.cloud/datasensor/datasensor.php";

// Offset kalibrasi (sesuaikan dengan hasil pengukuran manual)
float offsetSuhu = 0.8;  // Ganti dengan nilai offset suhu Anda
float offsetKelembapan = -19;  // Ganti dengan nilai offset kelembapan Anda

void setup() {
  Serial.begin(115200);
  dht.begin();

  // Konfigurasi WiFi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to ");
  Serial.println(ssid);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println(WiFi.localIP());
}

void loop() {
  float rawHumidity = dht.readHumidity();
  float rawTemperature = dht.readTemperature();

  // Terapkan offset kalibrasi
  float humidity = rawHumidity + offsetKelembapan;
  float temperature = rawTemperature + offsetSuhu;

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    Serial.println("[HTTP] begin...");

    // Membangun URL dengan parameter humidity dan suhu
    String url = String(server) + "?humidity=";
    url += String(humidity, 1); // Ubah presisi desimal sesuai kebutuhan
    url += "&suhu=";
    url += String(temperature, 1); // Ubah presisi desimal sesuai kebutuhan
    
    Serial.println(url);
    http.begin(wifiClient, url);

    Serial.println("[HTTP] GET...");
    int httpCode = http.GET();

    if (httpCode > 0) {
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK) {
        Serial.println("Berhasil mengirimkan data ke server");
      } else {
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }
    }
    http.end();
  } else {
    Serial.println("WiFi tidak terhubung...");
  }
  delay(5000); // Ubah interval pengiriman data sesuai kebutuhan
}
