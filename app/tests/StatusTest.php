<?php
define ( "SITE_ROOT", "/var/www/studentcrm/public_html/" );
require (SITE_ROOT . 'vendors/composer/vendor/autoload.php');
require (SITE_ROOT . 'app/libraries/Status.php');

class StatusTest extends \PHPUnit_Framework_TestCase
{

    function testFileName()
    {
        $this->assertFileExists('../../static/status.log');
    }


    function testUpdateStatus()
    {

        $this->assertNotNull(StudentCRM\Status::updateStatus('UP'));
    }

    function testUpdateStatusTemplate()
    {
        $this->assertNotNull(StudentCRM\Status::updateStatusTemplate('UP', 'System is online'));
    }

}