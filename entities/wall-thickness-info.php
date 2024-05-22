<?php

class WallThickness {
    private int $id = 0;
    private float $value = 0.0;

    public function __construct($id = 0, $value = 0.0)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public static function PostMapping() : WallThickness
    {
        $wall_thickness = new WallThickness();
        if (!empty($_POST['value']))
            $wall_thickness->set_value($_POST['value']);

        return $wall_thickness;
    }

    public function get_id() { return $this->id; }
    public function get_value() { return $this->value; }

    public function set_id($value) { $this->id = $value; }
    public function set_value($value) { $this->value = $value; }
}
