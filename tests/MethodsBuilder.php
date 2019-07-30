<?php

require "../vendor/autoload.php";

use SMITExecute\Library\QueriesBuilder\MethodsBuilder;

$builder = new MethodsBuilder();
$result = $builder
    ->setMainMethod("messages")
    ->setSubMethod("send")
    ->setParams([
        "user_id" => 89481221,
        "message" => "хай"
    ])
    ->build();

var_dump($result);