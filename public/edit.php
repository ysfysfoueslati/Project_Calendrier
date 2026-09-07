<?php

use App\Validator;
use Calendar\Events;
require_once('../src/boostrap.php');
require_once('../src/App/Validator.php');
require_once('../src/Calendar/EventValidator.php');
require_once('../src/Calendar/Event.php');
require_once('../src/Calendar/Events.php');

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors = [];

try{
    $event = $events->find($_GET['id'] ?? null);
} catch(\Exception $e){
    e404();
} catch(\Error $e){
    e404();
}

$data=[
    'name'=>$event->getName(),
    'date'=>$event->getStart()->format('Y-m-d'),
    'start'=>$event->getStart()->format('H:i'),
    'end'=>$event->getEnd()->format('H:i'),
    'description'=>$event->getDescription()
];

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $data=$_POST;
    $validator=new Calendar\EventValidator();
    $errors=$validator->validates($data);
    if (empty($errors)){
        $events->hydrate($event,$data);
        $events->update($event);
        header('Location: /index?success=1');
        exit();
    }
}

render('header',['title' => $event->getName()]);
?>
<div class="container">
    <h1>Editer l'evenement <small><?= h($event->getName());?></small></h1>
    <form action="" method="post" class="form">
        <?php render('calendar/form',['data'=>$data,'errors'=>$errors]); ?>  
        <div class="form-group">
            <button class="btn btn-primary">Modifier l'evenement</button>
        </div>
    </form>
</div>
<?php render('footer') ?>