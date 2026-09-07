<?php

use App\Validator;
require_once('../src/boostrap.php');
require_once('../src/App/Validator.php');
require_once('../src/Calendar/EventValidator.php');
require_once('../src/Calendar/Event.php');
require_once('../src/Calendar/Events.php');
$data=[
    'date'=>$_GET['date'] ?? date('Y-m-d'),
    'start'=>date('H:i'),
    'end'=>date('H:i')
];
$validator= new Validator($data);
if (!$validator->validate('date','date')){
    $data['date']=date('Y-m-d');
}
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $data=$_POST;
    $validator=new Calendar\EventValidator();
    $errors=$validator->validates($_POST);
    if (empty($errors)){
        $events = new \Calendar\Events(get_pdo());
        $event = $events->hydrate(new Calendar\Event(),$data);
        $events->create($event);
        header('Location: /index?success=1');
        exit();
    }
}
render('header',['title'=>'Ajouter un evenement']);
?>

<?php if (!empty($errors)): ?>
    <div class="container">
        <div class="alert alert-danger">
            Merci de corriger vos erreurs
        </div>
    </div>
<?php endif;?>
<div class="container">
    <h1>Ajouter un evenement</h1>
    <form action="" method="post" class="form">
        <?php render('calendar/form',['data'=>$data,'errors'=>$errors]); ?>  
        <div class="form-group">
            <button class="btn btn-primary">Ajouter l'evenement</button>
        </div>
    </form>
</div>

<?php render('footer')?>