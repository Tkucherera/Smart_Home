from gpiozero import MotionSensor
import RPi.GPIO as GPIO
import datetime, csv,time, dht11
# initialize GPIO
GPIO.setwarnings(True)
GPIO.setmode(GPIO.BCM)
# dht11 using pin 17
instance = dht11.DHT11(pin=17)
#motion sensor using pin 4 
pir = MotionSensor(4)
counter = 1
while True:
    pir.wait_for_motion()
    if pir.motion_detected:
        print("Someone in room")
        #when there is motion right the temp of the room to a file
        result = instance.read()
        if result.is_valid():
            date = str(datetime.datetime.now())
            temp = str(result.temperature)
            humidity = str(result.humidity)
            with open('temp.csv', 'a', newline = '') as f:
                write = csv.writer(f, delimiter = ' ')
                    write.writerow(['date','temp','humidity'])
                write.writerow([date, temp, humidity])
            time.sleep(10)
            if counter == 1: