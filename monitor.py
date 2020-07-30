import RPi.GPIO as GPIO
import dht11
import time
import datetime

# initialize GPIO
GPIO.setwarnings(True)
GPIO.setmode(GPIO.BCM)

# read data using pin 14
instance = dht11.DHT11(pin=14)
counter = 1
try:
	while True:
		result = instance.read()
	    if result.is_valid():
	    	date =str(datetime.datetime.now())
			temp =str(result.temperature)
			humidity=str(result.humidity)
			with open('data.csv', 'a', newline= ' ') as f:
				write = csv.writer(f, delimiter = '')
				if counter == 1:
					write.writerow(['date', 'temp','humidity'])
				write.writerow([date,temp,humidity])

	    time.sleep(6)
		counter+=1

except KeyboardInterrupt:
    print("Cleanup")
    GPIO.cleanup()