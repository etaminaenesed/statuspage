<?php
namespace StudentCRM;

class Status {

public $numResults;
private $statusStates = array('UP', 'DOWN');
private $statusTemplates = array();
private $statusLogs = array();
private $statusLogMessages = array();
const LOG_FILE = '/var/www/studentcrm/public_html/static/status';
const STATUS_TEMPLATES_FILE = '/var/www/studentcrm/public_html/static/statusMessageTemplates.json';


	public function __construct($numResults)
	{
        $this->numResults = $numResults;
        $this->getStatusTemplates();
        try {
            $this->getStatusLogs();
        }
        catch(\Exception $e) {
            $this->error = $e->getMessage();
        }

        /** When errors occur, service is unavailable */
        if($this->error) {
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            exit;
        }

	}

    /**
     * Get Status Templates
     * Get the text templates used for printing the status message
     */
    private function getStatusTemplates() {
        $jsonStatusTemplates = file_get_contents (self::STATUS_TEMPLATES_FILE);
        $this->statusTemplates = json_decode($jsonStatusTemplates, true);
    }

    /**
     * Get Status Logs
     * Get the last logs from /statics/status.log
     * @throws Exception
     */
    private function getStatusLogs() {


        if (!file_exists(self::LOG_FILE)) {
            throw new Exception('Logs file does not exist');
        }
        elseif (!is_readable(self::LOG_FILE)) {
            throw new Exception('Logs file can not be read');
        }
        else {

            $logs = file(self::LOG_FILE);
            $i = 0;
            $numLines = count($logs);
            while($i<$this->numResults) {
                $i++;
                $this->statusLogs[] = $logs[$numLines - $i];
            }
        }
    }

    /**
     * Get Status Log Messages
     * Converts the raw logs in a user friendly through the template messages
     * available at /static/statusMessageTemplates.json
     * @return array
     */
    public function getStatusLogMessages() {
        foreach($this->statusLogs as $log) {
            $log = explode(",", $log);
            $logMessage = &$log[0];
            $logTimestamp = &$log[1];
            $this->statusLogMessages[] = array($this->statusTemplates[ $logMessage ], date("Y:m:d h:i:s", $logTimestamp));
        }

        return $this->statusLogMessages;
    }


    /**
     * Update Status
     * It manually updates the current system status.
     * Eq: curl -X POST "http://student-crm.nedelcu.info/status/set/up";
     * Eq: curl -X POST "http://student-crm.nedelcu.info/status/set/down";
     * @param $status
     * @return string
     */
    public static function updateStatus($status) {
       $status = strtoupper($status);
        if($status == 'UP' || $status == 'DOWN') {
            $newRecord = strtoupper($status) .','. time() . PHP_EOL;
            $insertNewRecord = file_put_contents(self::LOG_FILE, $newRecord, FILE_APPEND|LOCK_EX);
            $insertNewRecord == true ? $statusMessage = 'success'.PHP_EOL : $statusMessage = 'error'.PHP_EOL;
            return $statusMessage;
        }
        else { return 'error'.PHP_EOL; }
    }


    /**
     * Update Status Template
     * Updates the way status logs are formatted
     * Eq: curl -G -X PUT "http://student-crm.nedelcu.info/status/template/up" --data-urlencode "value=Student-CRM is online"
     * Eq: curl -G -X PUT "http://student-crm.nedelcu.info/status/template/down" --data-urlencode "value=Student-CRM is offline"
     * @param $template
     * @param $value
     * @return string
     */
    public static function updateStatusTemplate($template, $value) {
        $template = strtoupper($template);
        if($template == 'UP' || $template == 'DOWN') {
            $jsonStatusTemplates = file_get_contents(self::STATUS_TEMPLATES_FILE);
            $templates = json_decode($jsonStatusTemplates, true);
            $templates[$template] = $value;
            $jsonTemplates = json_encode($templates);
            $updateStatusTemplates = file_put_contents(self::STATUS_TEMPLATES_FILE, $jsonTemplates);
            return 'success'.PHP_EOL;
        }
        else { return 'error'.PHP_EOL; }
    }

}