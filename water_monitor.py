import RPi.GPIO as GPIO
import time, datetime
import mysql.connector as mariadb

# change these as desired - they're the pins connected from the
# SPI port on the ADC to the Cobbler
SPICLK = 11
SPIMISO = 9
SPIMOSI = 10
SPICS = 8

# photoresistor connected to adc #0
photo_ch = 0

#open database
mydb = mariadb.connect(
    host = "localhost",
    user = "Tinashe",
    password = 'Smarthome',
    database = 'mydatabase'
    )

#port init
def init():
         GPIO.setwarnings(False)
         GPIO.cleanup()         #clean up at the end of your script
         GPIO.setmode(GPIO.BCM)     #to specify whilch pin numbering system
         # set up the SPI interface pins
         GPIO.setup(SPIMOSI, GPIO.OUT)
         GPIO.setup(SPIMISO, GPIO.IN)
         GPIO.setup(SPICLK, GPIO.OUT)
         GPIO.setup(SPICS, GPIO.OUT)
         
#read SPI data from MCP3008(or MCP3204) chip,8 possible adc's (0 thru 7)
def readadc(adcnum, clockpin, mosipin, misopin, cspin):
        if ((adcnum > 7) or (adcnum < 0)):
                return -1
        GPIO.output(cspin, True)    

        GPIO.output(clockpin, False)  # start clock low
        GPIO.output(cspin, False)     # bring CS low

        commandout = adcnum
        commandout |= 0x18  # start bit + single-ended bit
        commandout <<= 3    # we only need to send 5 bits here
        for i in range(5):
                if (commandout & 0x80):
                        GPIO.output(mosipin, True)
                else:
                        GPIO.output(mosipin, False)
                commandout <<= 1
                GPIO.output(clockpin, True)
                GPIO.output(clockpin, False)

        adcout = 0
        # read in one empty bit, one null bit and 10 ADC bits
        for i in range(12):
                GPIO.output(clockpin, True)
                GPIO.output(clockpin, False)
                adcout <<= 1
                if (GPIO.input(misopin)):
                        adcout |= 0x1

        GPIO.output(cspin, True)
        
        adcout >>= 1       # first bit is 'null' so drop it
        return adcout

def main():
         init()
         time.sleep(2)
         while True:
                  adc_value=readadc(photo_ch, SPICLK, SPIMOSI, SPIMISO, SPICS)  
                  if adc_value>=30 and adc_value<200 :
                           amount= "water flow"
                           water_level = (adc_value/200)*100                    
                           mycursor = mydb.cursor()
                           sql = "INSERT INTO water_level (date_time, waterlevel, amount) VALUES (%s, %s, %s)"
                           val = (datetime.datetime.now(), water_level, amount)
                           mycursor.execute(sql, val)
                           mydb.commit()     
                  #print "adc_value= " +str(adc_value)+"\n"
                  time.sleep(3)
        

if __name__ == '__main__':
         try:
                  main()
                 
         except KeyboardInterrupt:
                  pass
GPIO.cleanup()
