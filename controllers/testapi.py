import requests, datetime

_data = [0,datetime.datetime.now().strftime("%Y-%m-%d %H:%M"),7.0,90,3.6,1.1,6.3,1.3,27.5,298,0,3]

_id = str(_data[0])
_date = str(_data[1])
_ph = str(_data[2])
_do = str (_data[3])
_sal = str (_data[4])
_amm = str (_data[5])
_nit = str (_data[6])
_tur = str (_data[7])
_temp = str (_data[8])
_depth = str (_data[9])
_type = str (_data[10])
_userid = str(_data[11])

_tank_id = str(173571)
_name = "Sensor 3rd"

log_url = 'http://localhost:8080/api/add-log?sensor_id='+_id+'&datetime='+_date+'&ph='+_ph+'&do='+_do+'&sal='+_sal+'&amm='+_amm+'&nit='+_nit+'&tur='+_tur+'&temp='+_temp+'&dep='+_depth+'&type='+_type+'&id='+_userid+''
sensor_url = 'http://localhost:8080/api/add-sensor?tank_id='+_tank_id+'&name='+_name+'&type='+_type+'&id='+_userid+''
test_url = 'http://13.251.178.77:8080/'
response = requests.get(url=test_url)
print(response.text)
print (len(_data))