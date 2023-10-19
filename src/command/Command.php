<?php declare(strict_types = 1);

use command\Receiver;
use command\Sender;

error_reporting(E_ALL & ~E_DEPRECATED);

if (!isset($argv[1])) {
    exit(0);
}

require __DIR__ . '/../config/bootstrap.php';

global $container;

$command = match ($argv[1]) {
    'send' => $container->get(Sender::class),
    'receive' => $container->get(Receiver::class),
    default => throw new InvalidArgumentException('Arg can be only send or receive'),
};

$command->run();
