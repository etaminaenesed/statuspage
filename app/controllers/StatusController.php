<?php

class StatusController {

    public function getStatus($url)
    {

        /** GET STUDENT-CRM STATUS */
        $numResults = 10;
        $status = new StudentCRM\Status($numResults);

        /** Get log messages */
        $statusLogMessages = $status->getStatusLogMessages();
        $htmlStatusPage = '<table><tr><th>Status message</th><th>Hour</th></tr>';
        foreach($statusLogMessages as $status) {
          $htmlStatusPage .= "<tr><td>$status[0]</td><td>$status[1]</td></tr>";
        }
        $htmlStatusPage .='</table>';
        require VIEWS . 'status.tpl.php';

    }

    public function updateStatusTemplate($url)
    {

        $updateStatusTemplate = \StudentCRM\Status::updateStatusTemplate($url[3], $url[4]);
        print $updateStatusTemplate;

    }

    public function updateStatus($url)
    {
     $updateStatus = \StudentCRM\Status::updateStatus($url[3]);
     print $updateStatus;
    }


}