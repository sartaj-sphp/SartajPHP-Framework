<?php

$dynData = new TempFile("{$apppath}/forms/error_msg.php");

$dynData->run();
include_once("$masterf");
