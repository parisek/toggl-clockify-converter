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

  $database->query('CREATE TABLE IF NOT EXISTS projects(id INTEGER PRIMARY KEY, name TEXT, client_id INT)');

  $count = 0;

  $projects = JsonMachine::fromFile(__DIR__ . '/data/projects.json');
  foreach ($projects as $project) {
    $result = $database->query('SELECT * FROM projects WHERE id = ?', $project['id']);
    if(count($result->fetchAll()) === 0) {
      $database->query('INSERT INTO projects', [
        'id' => $project['id'],
        'name' => $project['name'],
        'client_id' => $project['client_id'],
      ]);
    }
  }

  echo 'Affected ' . $count . ' results';

} catch (Dibi\Exception $e) {
  echo get_class($e), ': ', $e->getMessage(), "\n";
}
