from gpiozero import MotionSensor
import RPi.GPIO as GPIO
import datetime, csv,time, dht11
import mysql.connector as mariadb
# initialize GPIO
GPIO.setwarnings(True)
GPIO.setmode(GPIO.BCM)
# dht11 using pin 17
instance = dht11.DHT11(pin=17)
#motion sensor using pin 4 
pir = MotionSensor(4)
#open database
mydb = mariadb.connect(
    host = "localhost",
    user = "Tinashe",
    password = 'Smarthome',
    database = 'mydatabase'
    )
counter = 1
while True:
    pir.wait_for_motion()
    if pir.motion_detected:
        
        #when there is motion right the temp of the room to a file
        result = instance.read()
        if result.is_valid():
            temp = int(result.temperature)
            humidity = str(result.humidity)
            #insert values into database
        mycursor = mydb.cursor()
        sql = "INSERT INTO Temp_humidity (date_time, temp, humidity) VALUES (%s, %s, %s)"
        val = (datetime.datetime.now(), temp, humidity)
        mycursor.execute(sql, val)
        mydb.commit()           
        time.sleep(10)
    
    counter+=1