<?php

use \JsonMachine\JsonMachine;

try {

  $database = new Dibi\Connection([
    'driver'   => 'sqlite',
    'database' => __DIR__ . '/sqlite/sqlite.sdb',
    'profiler' => [
      'file' => __DIR__ . '/sqlite/sqlite.log',
    ],
  ]);

  $database->query('CREATE TABLE IF NOT EXISTS clients(id INTEGER PRIMARY KEY, name TEXT, wid INT)');

  $count = 0;

  $clients = JsonMachine::fromFile(__DIR__ . '/data/clients.json');
  foreach ($clients as $client) {
    $result = $database->query('SELECT * FROM clients WHERE id = ?', $client['id']);
    if(count($result->fetchAll()) === 0) {
      $database->query('INSERT INTO clients', [
        'id' => $client['id'],
        'name' => $client['name'],
        'wid' => $client['wid'],
      ]);
    }
  }

  echo 'Affected ' . $count . ' results';

} catch (Dibi\Exception $e) {
  echo get_class($e), ': ', $e->getMessage(), "\n";
}
