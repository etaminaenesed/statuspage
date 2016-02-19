#Task
##############################################
Write a PHP or CakePHP (prefered)application that consists of a simple system status page
for the Student CRM. The purpose of this page is to let customers know whether the system
is currently available and whether there have been any recent incidents.
The system status and status messages should only be able to be updated from the
command line using cURL, don’t worry about authentication or the design of the status page,
but do pay attention to its structure.
There is no requirement to deploy the application beyond running it locally.
The final deliverable:
? Should have a single web page showing the current status and a history of the last
10 status messages with their timestamp.
? Should offer an API to manually update the status message and the current status.
? Should support ONLY 2 possible status options: “UP” or “DOWN”.
? Should allow updating of a status message without changing the status.
? Should allow changing of the status without leaving a status message.
? Should NOT actually monitor anything, the status will only be updated manually via
cURL.
? Should be suitably tested.
? Should have a README with instructions and cURL commands needed to operate
the system.
? Should be delivered as a zipped git repository.
? Could include some Unit Testing.

#Requirements
##############################################
PHP 5.6
Composer
PHPUnit

#Demo
##############################################
http://student-crm.nedelcu.info/status/

#cURL commands
##############################################
1.Manually set the current status:
curl -X POST "http://student-crm.nedelcu.info/status/set/up";
curl -X POST "http://student-crm.nedelcu.info/status/set/down";
2. Change a status message template:
curl -G -X PUT "http://student-crm.nedelcu.info/status/template/up" --data-urlencode "value=Student-CRM is online"
curl -G -X PUT "http://student-crm.nedelcu.info/status/template/down" --data-urlencode "value=Student-CRM is offline"