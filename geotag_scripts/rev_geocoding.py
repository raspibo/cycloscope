#!/usr/bin/python

import json
import urllib2
import sys
from sys import argv

script, lat, lon = argv

response = urllib2.urlopen('http://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lon + '&format=json&addressdetails=1&email=castellariatalice.it&accept-language=en-gb')
#result = json.loads(response.read().decode('utf-8'))
result = json.loads(response.read())
#result=json.load(response)
#print result
#print json.dumps(result, indent=4, sort_keys=True)
location=""
if 'town' in result['address'] :
	location+=", " + result['address']['town']
if 'state' in result['address'] :
	location+=", " + result['address']['state']
if 'country' in result['address'] :
	location=result['address']['country']
if 'country_code' in result['address'] :
	location+=", " + result['address']['country_code']
if location :
	print location
