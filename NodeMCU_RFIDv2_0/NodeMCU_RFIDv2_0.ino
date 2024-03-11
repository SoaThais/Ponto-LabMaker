//************************************************************************

#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

#define SS_PIN  D8  
#define RST_PIN D0
MFRC522 mfrc522(SS_PIN, RST_PIN);

//************************************************************************

// const char *ssid = "Leticia_2.4G-S3cj";
// const char *password = "75395112e15";
// const char *ssid = "Thais";
// const char *password = "cxbv9472";
// const char* device_token  = "84d41655cfe60f14";


const char *ssid = "GETEngComp";
const char *password = "45419911";
const char* device_token  = "6cb79a00397d6914";

// String URL = "http://192.168.56.1:8080/FreqMaker/getdata.php"; 
// String URL = "http://192.168.100.185:8080/FreqMaker/getdata.php";

String URL = "http://192.168.0.104:80/getdata.php";

String getData, Link;
String OldCardID = "";
unsigned long previousMillis = 0;

int ledVermelho = 5;
int ledVerde = 4;
int ledAmarelo = 0;

void setup() {
  pinMode(ledVermelho, OUTPUT);
  pinMode(ledVerde, OUTPUT);
  pinMode(ledAmarelo, OUTPUT);

  delay(100);

  digitalWrite(ledVermelho, LOW);
  digitalWrite(ledVerde, LOW);
  digitalWrite(ledAmarelo, LOW);

  Serial.begin(19200);
  SPI.begin();  
  mfrc522.PCD_Init();
  connectToWiFi();
}

void loop() {

  digitalWrite(ledVermelho, LOW);
  digitalWrite(ledVerde, LOW);
  digitalWrite(ledAmarelo, LOW);

  if(!WiFi.isConnected()){
    connectToWiFi();  
  }
  
  if (millis() - previousMillis >= 5000) {
    previousMillis = millis();
    OldCardID = "";
  }

  delay(50);

  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  String CardID = "";

  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }

  if(CardID == OldCardID){
    return;
  }
  else{
    OldCardID = CardID;
  }
  
  SendCardID(CardID);
  delay(1000);
}

void SendCardID(String Card_uid){

  Serial.println("Sending the Card ID");

  if(WiFi.isConnected()){
    HTTPClient http;  
    WiFiClient client;

    http.begin(client, URL);

    http.setAuthorization("localhost", "");

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String httpRequestData = "card_uid=" + String(Card_uid) + "&device_token=" + String(device_token);

    http.addHeader("Content-Length", String(sizeof(httpRequestData)));

    int httpCode = http.POST(httpRequestData);

    String payload = http.getString(); 

    Serial.print("httpCode: ");
    Serial.println(httpCode);  
    Serial.print("card_uid: ");
    Serial.println(Card_uid);   
    Serial.print("payload: "); 
    Serial.println(payload);  

    if (httpCode == 200) {
      if (payload.substring(0, 5) == "login") {
        String user_name = payload.substring(5);
        digitalWrite(ledVerde, HIGH);
      }
      else if (payload.substring(0, 6) == "logout") {
        String user_name = payload.substring(6);   
        digitalWrite(ledVerde, HIGH);     
      }
      else if (payload == "succesful") {
        digitalWrite(ledVerde, HIGH);
      }
      else if (payload == "available") {
        digitalWrite(ledAmarelo, HIGH);
      }
      else {
        digitalWrite(ledVermelho, HIGH);
      }
      delay(100);
      http.end(); 
    }
    else {
      digitalWrite(ledVermelho, HIGH);
      // delay(100);
      // http.end();
    }
  }
}

void connectToWiFi(){
    WiFi.mode(WIFI_OFF);      
    delay(1000);
    WiFi.mode(WIFI_STA);

    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
      digitalWrite(ledVermelho, HIGH);
    }

    digitalWrite(ledVermelho, LOW);

    Serial.println("");
    Serial.println("Connected");
  
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP()); 
    
    delay(1000);
}