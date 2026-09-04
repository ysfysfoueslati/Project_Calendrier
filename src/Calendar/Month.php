<?php
namespace src\Calendar;

use DateTime;
class Month{
    private $months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    public $month;
    public $year;
    /**
     * month constructor
     *@param int $month le mois entre 1 et 12
     * @param int $year l'annee
     * @throws \Exception
     */
    public function __construct(?int $month=null,?int $year=null){
        if ($month === null || $month < 1 || $month > 12){
            $month=intval(date(format:'m'));
        }
        if ($year===null){
            $year=intval(date(format:'Y'));
        }

        
        if ($year <1970){
            throw new \Exception("l'annee est inferieur a 1970");
        }
        $this->month=$month;
        $this->year=$year;
    }
    /**
     * retourne le premier jour du mois
     * @return DateTime
     */
    public function getStartingDay():DateTime{
        return new DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * retourne le mois en toute lettres
     * @return string
     */
    public function tostring():string{
        return $this->months[$this->month - 1] . ' ' .$this->year;
    }
    /**
     * retourne le nombre de semaines
     * @return int
     */
    public function getWeeks():int{
        $start=$this->getStartingDay();
        $end=(clone $start)->modify('+1 month -1 day');
        $weeks=intval($end->format('W'))-intval($start->format('W')) + 1 ;
        if ($weeks<0){
            $weeks=intval($start->format('W'));
        }
        return $weeks;
    }
    /**
     * est ce que le jour est dans le mois courant
     * @param DateTime $date
     * @return bool
     */
    public function withinMonth(DateTime $date):bool{
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }
    /**
     * renvoie le mois suivant
     * @return Month
     */
    public function nextMonth():Month{
        $month=$this->month +1;
        $year=$this->year;
        if ($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month,$year);
    }
    /**
     * renvoie le mois precedent
     * @return Month
     */
    public function previousMonth():Month{
        $month=$this->month -1;
        $year=$this->year;
        if ($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month,$year);
    }
}   