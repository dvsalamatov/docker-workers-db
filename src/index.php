<?php declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use contracts\repository\ReportRepositoryInterface;

require __DIR__ . '/config/bootstrap.php';

global $container;

/**
 * @var $repository ReportRepositoryInterface
 */
$repository = $container->get(ReportRepositoryInterface::class);

$res = $repository->getStatistic();

?>

<table>
    <tr>
        <th>Минута</th>
        <th>Минимальное время</th>
        <th>Максимальное время</th>
        <th>Кол-во строк</th>
        <th>Средняя длинна</th>
    </tr>

<?php

foreach ($res as $num => $item) {
    ?>
    <tr>
        <td><?php echo $item->getMinute(); ?></td>
        <td><?php echo $item->getMinTime()->format('Y-m-d H:i:s'); ?></td>
        <td><?php echo $item->getMaxTime()->format('Y-m-d H:i:s'); ?></td>
        <td><?php echo $item->getSumCountLines(); ?></td>
        <td><?php echo $item->getAvgLength(); ?></td>
    </tr>
    <?php
}
?>

</table>
