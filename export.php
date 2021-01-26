<?php

use League\Csv\Writer;

try {

  $database = new Dibi\Connection([
    'driver'   => 'sqlite',
    'database' => __DIR__ . '/sqlite/sqlite.sdb',
    'profiler' => [
      'file' => __DIR__ . '/sqlite/sqlite.log',
    ],
  ]);

  $result = $database->query("SELECT p.name as 'Project', c.name as 'Client', t.name as 'Task' FROM tasks t LEFT JOIN projects p ON t.project_id = p.id LEFT JOIN clients c ON p.client_id = c.id");
  $items = $result->fetchAll();

  $writer = Writer::createFromFileObject(new SplTempFileObject());

  $writer->insertOne(['Project', 'Client', 'Task']);
  foreach ($items as $item) {
    $writer->insertOne((array) $item);
  }

  $writer->output('clockify.csv');

  exit;

} catch (Dibi\Exception $e) {
  echo get_class($e), ': ', $e->getMessage(), "\n";
}
