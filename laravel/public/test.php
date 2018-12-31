<?php

require_once '../vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;

$client = ClientBuilder::create()
    ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
    ->build();
$query = "MATCH (n:Teacher) RETURN n";
$result = $client->run($query);

foreach ($result->getRecords() as $record) {
    print_r($record->value("n")->value("nid"));
    echo "\t";
    print_r($record->value("n")->value("name"));
    echo "\t";
    print_r($record->value("n")->value("teacher_status"));
    echo "<br>";
}