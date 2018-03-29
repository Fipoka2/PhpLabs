<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use function MongoDB\BSON\toJSON;
use function Sodium\add;

class Labs extends Controller
{
    public function index() {
        $results = DB::select("select * from university where city='Москва' AND rating <
          (select rating from university WHERE name='ВГУ')", [1]);
        $list = array();
        foreach ($results as $user) {
            $s = new obg();
            $s->name = $user->name;
            $list[]= $s; //обращение к полю
        }
        return $list;
    }

    public function getStudents() {
        $results = DB::select("select surname,name,kurs from students where stipend>140", [1]);
        return $results;
    }

    public function getBySurname() {
        $surname= Input::get("surname");
        $results = DB::select("select name from students where surname=:n", ['n' => $surname]);
        return $results;
    }

    public function getSurnames() {
        $results = DB::select("select surname from students", [1]);
        return $results;
    }


}

class obg {
    public $name = "";
     public function prints() {
         echo $this->name;
     }
}
