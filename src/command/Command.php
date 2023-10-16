<?php declare(strict_types = 1);

use command\Receiver;
use command\Sender;
use components\db\DB;
use repository\UrlStacMariaDbRepository;

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..');
$dotenv->load();

if (!isset($argv[1])) {
    exit(0);
}

// TODO Use DI
$queue = new queue\Queue('hello');

switch ($argv[1]) {
    case 'send':
        $command = new Sender($queue);
        break;
    case 'receive':
        $db = DB::getDb();
        $urlStatRepository = new UrlStacMariaDbRepository($db);
        $command = new Receiver($queue, $urlStatRepository);
        break;
    default:
        throw new InvalidArgumentException('Arg can be only send or receive');
}

$command->run();
