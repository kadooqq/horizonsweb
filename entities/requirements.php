<?php

class Requirements {
    private int $id = 0;
    private bool $chamfer = false;
    private Diameter $diameter;
    private Gost $gost;
    private SteelGrade $steel_grade;
    private WallThickness $wall_thickness;
    private MechProp $mech_prop;
    private Test $test;
    private float $mech_prop_val; 
    private float $test_val;
    private string $requirements_text = "";

    public function __construct($id = 0, $chamfer=false, $diameter=null, $gost=null, 
                                $steel_grade=null, $wall_thickness=null, $mech_prop = null, 
                                $mech_prop_val = 0.0, $test = null, $test_val = 0.0, $requirements_text="") 
    {
        $this->id = $id;
        $this->chamfer = $chamfer;
        $this->diameter = $diameter;
        $this->gost = $gost;
        $this->steel_grade = $steel_grade;
        $this->wall_thickness = $wall_thickness;
        $this->mech_prop = $mech_prop ? $mech_prop : new MechProp();
        $this->mech_prop_val = $mech_prop_val ? $mech_prop_val : 0;
        $this->test = $test ? $test : new Test();
        $this->test_val = $test_val ? $test_val : 0;
        $this->requirements_text = $requirements_text;
    }

    public function get_id() { return $this->id; }
    public function get_chamfer() { return $this->chamfer; }
    public function get_diameter() { return $this->diameter; }
    public function get_gost() { return $this->gost; }
    public function get_steel_grade() { return $this->steel_grade; }
    public function get_wall_thickness() { return $this->wall_thickness; }
    public function get_mech_prop() { return $this->mech_prop; }
    public function get_mech_prop_val() { return $this->mech_prop_val; }
    public function get_test() { return $this->test; }
    public function get_test_val() { return $this->test_val; }
    public function get_requirements_text() { return $this->requirements_text; }
    
    public function set_id($value) { $this->id = $value; }
    public function set_chamfer($value) { $this->chamfer = $value; }
    public function set_diameter_id($value) { $this->diameter = $value; }
    public function set_gost_id($value) { $this->gost = $value; }
    public function set_steel_grade_id($value) { $this->steel_grade = $value; }
    public function set_wall_thickness_id($value) { $this->wall_thickness = $value; }
    public function set_mech_prop($value) { $this->mech_prop = $value; }
    public function set_mech_prop_val($value) { $this->mech_prop_val = $value; }
    public function set_test($value) { $this->test = $value; }
    public function set_test_val($value) { $this->test = $value; }
    public function set_requirements_text($value) { $this->requirements_text = $value; }
}
