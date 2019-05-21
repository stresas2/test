<?php

class MyClass
{
    public $input;

    public function check() {

      //nuskaitome suma kuria reikia apskaiciuoti
      $required_income = $this->input["required_income"];

      $sms_list = $this->input["sms_list"];

      $income_list_number = count($sms_list);

      //sukuriame rodykle, is visu galimu income rate
      $income_rate = array();

      for ($x = 0; $x <= $income_list_number-1; $x++) {

        $income_rate[$x] = $sms_list[$x]["income"];
      }

      //sukuriame rodykle, kurioje issigojame nuskaiciuotas sumas
      $first_final = [];

      //po kiekvieno atimimo tikriname likuti
      $likutis = $required_income;

      for($i = $income_list_number-1; $i >= 0; $i--){

          $kiekis_sveikais_skaiciais = intval($likutis / $income_rate[$i]);

          $likutis = $likutis - ($income_rate[$i] * $kiekis_sveikais_skaiciais);

        for($c = 0; $c <= $kiekis_sveikais_skaiciais-1; $c++){

          $first_final[] = $i;

        }

      }

      //tikriname ar visus galimus atimimus atlike lieka likutis, jei taip pridedame maziausi reiksme
      if($likutis > 0){
        $first_final[] = 0;
      }

      echo "[";

      //isspausdinam reiksmias galutinemis kainomis, "imituojam JSON"
      for ($a = 0; $a < count($first_final); $a++){

        echo " " . $sms_list[$first_final[$a]]["price"] . ", ";

      }

      echo "]";

    }
}

$input_json = file_get_contents("input.json");
$input = json_decode($input_json, true);


$MyClass = new MyClass;

$MyClass->input = $input;

$MyClass->check();

 ?>
