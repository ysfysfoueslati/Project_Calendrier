<?php
namespace src\Calendar;
class Events{
    private $pdo;
    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    /**
     * recuperer les evenements commenceant entre 2 bases
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventsBetween(\DateTime $start,\DateTime $end):array{
        $pdo = new \PDO('mysql:host=localhost;dbname=tutocalendar','root','root',[
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        $sql= "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ";
        $statement= $this->pdo->query($sql);
        $results = $statement->fetchAll();
        return $results;
    }
    /**
     * recuperer les evenements commenceant entre 2 bases indexe par jour
     * @param \DateTime $start
     * @param \DateTime $end
     * @return void
     */
    public function getEventsBetweenByDay(\DateTime $start,\DateTime $end):array{
        $events=$this->getEventsBetween($start,$end);
        $days=[];
        foreach($events as $events){
            $date=explode(' ' , $events['start'])[0];
            if (!isset($days[$date])){
                $days[$date]=[$events];
            }else{
                $days[$date][]=$events;
            }
        }
        return $days;
    }

    /**
     * recupere un evenement
     * @param int $id
     * @return array
     */
    public function find(int $id):\Event{
        require_once __DIR__ . '/Event.php';   // was: require('Event.php');
        $statement=$this->pdo->query("SELECT * FROM events WHERE id=$id LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, \Event::class);
        $result=$statement->fetch();
        if($result===false){
            throw new \Exception('aucun resultat trouvée');
        }
        return $result;
    }
}
?>