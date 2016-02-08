#Description
A simple status page script for Student-CRM that let you know if the system is live or not. 
The system is built on a simple, custom MVC framework on a LAMP environment.

#Requirements
PHP 5.6
Composer
PHPUnit

#Demo
http://student-crm.nedelcu.info/status/

#cURL commands
1.Manually set the current status:
curl -X POST "http://student-crm.nedelcu.info/status/set/up";
curl -X POST "http://student-crm.nedelcu.info/status/set/down";
2. Change a status message template:
curl -G -X PUT "http://student-crm.nedelcu.info/status/template/up" --data-urlencode "value=Student-CRM is online"
curl -G -X PUT "http://student-crm.nedelcu.info/status/template/down" --data-urlencode "value=Student-CRM is offline"