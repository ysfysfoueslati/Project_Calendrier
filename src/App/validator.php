<?php 

namespace App;

class Validator{
    private $data;
    protected $errors = [];

    public function __construct(array $data=[]){
        $this->data=$data;
    }
    

    public function validates(array $data){
        $this->data=$data;
        $this->errors=[];
        return $this->errors;
    }

    public function validate(string $field,string $method, ...$parameters):bool{
        if (!isset($this->data[$field])){
            $this->errors[$field] = "le champ $field n'est pas rempli";
            return false;
        }else{
            return call_user_func([$this,$method],$field,...$parameters);
        }
    }

    public function minLength(string $field, int $length): bool {
        if (\mb_strlen($this->data[$field]) < $length) {
            $this->errors[$field] = "le champ doit avoir plus de $length caracteres";
            return false;
        }
        return true;
    }   

    public function date(string $field):bool{
        if (\DateTime::createFromFormat('Y-m-d',$this->data[$field])===false){
            $this->errors[$field]="la date ne semble pas valide";
            return false;
        }
        return true;
    }
    public function time(string $field):bool{
        if (\DateTime::createFromFormat('H:i',$this->data[$field])===false){
            $this->errors[$field]="le temps ne semble pas valide";
            return false;
        }
        return true;
    }
    public function beforetime(string $startfield,string $endfield){
        if ($this->time($startfield) && $this->time($endfield)){
            $start=\DateTime::createFromFormat('H:i',$this->data[$startfield]);
            $end=\DateTime::createFromFormat('H:i',$this->data[$endfield]);
            if ($start->getTimestamp()>$end->getTimestamp()){
                $this->errors[$startfield]="le temps doit etre inferieur au temps du fin";
                return false;
            }
            return true;
        }
        return false;
    }
}