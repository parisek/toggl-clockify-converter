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

  $database->query('CREATE TABLE IF NOT EXISTS tasks(id INTEGER PRIMARY KEY, name TEXT, project_id INT)');

  $directory = __DIR__ . '/data/tasks';
  $directory_iterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
  $flattened = new RecursiveIteratorIterator($directory_iterator);

  $count = 0;

  $regex_iterator = new RegexIterator($flattened, '/\.json$/');
  foreach ($regex_iterator as $file) {
    $tasks = JsonMachine::fromFile($file->getPathname());
    foreach ($tasks as $task) {
      $result = $database->query('SELECT * FROM tasks WHERE id = ?', $task['id']);
      if(count($result->fetchAll()) === 0) {
        $database->query('INSERT INTO tasks', [
          'id' => $task['id'],
          'name' => $task['name'],
          'project_id' => $task['project_id'],
        ]);
        $count++;
      }
    }
  }

  echo 'Affected ' . $count . ' results';

} catch (Dibi\Exception $e) {
  echo get_class($e), ': ', $e->getMessage(), "\n";
}
