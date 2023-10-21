<?php declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use contracts\repository\UrlStatisticRepositoryInterface;

require __DIR__ . '/config/bootstrap.php';

global $container;

/**
 * @var $repository UrlStatisticRepositoryInterface
 */
$repository = $container->get(UrlStatisticRepositoryInterface::class);

$res = $repository->getStatistic();

foreach ($res as $num => $item) {
    echo $num + 1 . ': ' . $item . '<br>';
}
