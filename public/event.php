    <?php

    use src\Calendar\Events;
    require_once('../src/Calendar/Events.php');
    require_once('../src/boostrap.php');
    require_once('../src/Calendar/event.php');
    if (!isset($_GET['id'])){
        header('location: /404.php');
        exit;
    }
    $pdo=get_pdo();
    $event = new src\Calendar\Events($pdo);
    try{
        $event = $event->find($_GET['id']);
    } catch(\Exception $e){
        e404();
    }
    render('header',['title=>$event->getName()']);
    ?>

    <h1><?= h($event->getName());?></h1>

    <ul>
        <li>Date: <?= $event->getStart()->format('d/m/Y');?></li>
        <li>Heure de demarrage: <?= $event->getStart()->format('H:i');?></li>
        <li>Heure de fin: <?= $event->getEnd()->format('H:i');?></li>
        <li>
        Description:<br>
        <?= h($event->getDescription());?></li>
            
    </ul>

    <?php require('views/footer.php'); ?>