from datetime import datetime
import time

fmt = '%Y-%m-%d %H:%M:%S'
d1 = datetime.strptime('2016-08-21 13:50:00', fmt)
d2 = datetime.strptime('2014-08-21 03:37:33', fmt)

d1_ts = time.mktime(d1.timetuple())
d2_ts = time.mktime(d2.timetuple())

# they are now in seconds, subtract and then divide by 60 to get minutes.
print int(d2_ts-d1_ts)+3600 

d3 = datetime.strptime('2014-09-18 07:48:09', fmt)
d4 = datetime.strptime('2014-09-18 08:12:00', fmt)
d3_ts = time.mktime(d3.timetuple())
d4_ts = time.mktime(d4.timetuple())

# they are now in seconds, subtract and then divide by 60 to get minutes.
print int(d4_ts-d3_ts)+3600

