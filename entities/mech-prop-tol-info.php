<?php
    
class MechPropTol {
    private int $id = 0;
    private float $min = 0.0;
    private int $mech_prop_id = 0;
    private int $steel_grade_id = 0;

    public function __construct($id = 0, $min = 0.0, $mech_prop_id = 0, $steel_grade_id = 0)
    {
        $this->id = $id;
        $this->min = $min;
        $this->mech_prop_id = $mech_prop_id;
        $this->steel_grade_id = $steel_grade_id;
    }

    public function get_id() { return $this->id; }
    public function get_min() { return $this->min; }
    public function get_prop_id() { return $this->mech_prop_id; }
    public function get_steel_grade_id() { return $this->steel_grade_id; }

    public function set_id($value) { $this->id = $value; }
    public function set_min($value) { $this->min = $value; }
    public function set_mech_prop_id($value) { $this->mech_prop_id = $value; }
    public function set_steel_grade_id($value) { $this->steel_grade_id = $value; }
}
