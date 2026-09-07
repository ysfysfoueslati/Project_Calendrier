<?php
require_once('../src/boostrap.php');
require('../src/Calendar/Month.php');
require_once('../src/Calendar/Events.php');
$pdo=get_pdo();
$events=new Calendar\Events($pdo);
$month= new src\Calendar\Month(month:$_GET['month']??null,year:$_GET['year']??null);
$start=$month->getStartingDay();
$start=$start->format('N')===1 ? $start : $month->getStartingDay()->modify('last monday');
$weeks=$month->getWeeks();
$end=(clone $start)->modify('+' .(6+ 7 *($weeks -1)). 'days');
$events=$events->getEventsBetweenByDay($start,$end);
require('views/header.php');
?>

<div class="calendar">
    
    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h1><?= $month->toString()?></h1>
    <?php if (isset($_GET['success'])) :?>
        <div class="container">
            <div class="alert alert-success">
                L'évènement a bien ete enregistrée
            </div>
        </div>
    <?php endif;?>
    <div>
        <a href="/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt</a>
        <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt</a>
    </div>

    </div>
    <table class="calendar__table calendar__table--<?=$weeks;?>weeks">
        <?php for ($i=0;$i<$weeks;$i++):?>
        <tr>
            <?php foreach($month->days as $k => $day):
                $date=(clone $start)->modify("+" . ($k + $i*7) . "days");
                $eventsForDay=$events[$date->format('Y-m-d')] ?? [];  
                $isToday=date('Y-m-d')===$date->format('Y-m-d');
            ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
                <?php if ($i===0):?>
                    <div class="calendar__weekday"><?= $day; ?></div>
                <?php endif; ?>
                <a class="calendar__day" href="add.php?date=<?= $date->format('Y-m-d'); ?>"><?= $date->format('d'); ?></a>
                <?php foreach($eventsForDay as $event): ?>
                    <div class="calendar__event">
                        <?= (new DateTime($event['start']))->format('H:i')?> - <a href = "/edit.php?id=<?=$event['id']?>"><?=$event['name'];?></a>
                    </div>        
                <?php endforeach;?>
            </td>
            <?php endforeach;?>
        </tr>
        <?php endfor; ?>
    </table>
    <a href="/add.php" class="calendar__button">+</a>
</div>

<?php require('views/footer.php'); ?>