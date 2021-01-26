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

  $page = 0;
  if(filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
    $page = filter_var($_GET['page'], FILTER_VALIDATE_INT);
  }
  $page_count = 10000;
  $page_from = $page * $page_count;
  $page_to = ($page+1) * $page_count;

  $result = $database->query("SELECT p.name as 'Project', c.name as 'Client', t.name as 'Task' FROM clients c LEFT JOIN projects p ON p.client_id = c.id LEFT JOIN tasks t ON t.project_id = p.id LIMIT $page_from,$page_to");
  $items = $result->fetchAll();

  $writer = Writer::createFromFileObject(new SplTempFileObject());

  $writer->insertOne(['Project', 'Client', 'Task']);
  foreach ($items as $item) {
    $writer->insertOne((array) $item);
  }

  $writer->output('clockify-' . $page . '.csv');

  exit;

} catch (Dibi\Exception $e) {
  echo get_class($e), ': ', $e->getMessage(), "\n";
}
