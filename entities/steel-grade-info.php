<?php

class SteelGrade {
    private int $id = 0;
    private string $name = "";

    public function __construct($id = 0, $name = "")
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function PostMapping() : SteelGrade
    {
        $steel_grade = new SteelGrade();
        if (!empty($_POST['name']))
            $steel_grade->set_name($_POST['name']);

        return $steel_grade;
    }

    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }

    public function set_id($value) { $this->id = $value; }
    public function set_name($value) { $this->name = $value; }
}
