<?php

    if($url[1] === 'status' && !$url[2] && PFA_REQ === 'GET') { StatusController::getStatus($url); }
    elseif($url[1] === 'status' && $url[2] === 'template' && $url[3] && REQ === 'PUT') {
        StatusController::updateStatusTemplate($arr); }
    elseif($url[1] === 'status' && $url[2] === 'set' && $url[3] && REQ === 'POST') { StatusController::updateStatus($url); }
    else { header("HTTP/1.0 404 Not Found"); }