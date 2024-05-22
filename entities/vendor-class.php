<?php

class Vendor {
    private int $id = 0;
    private string $name = "";
    private string $shortname = "";
    private string $region = "";

    public function __construct($id = 0, $name = "", $shortname = "", $region = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->shortname = $shortname;
        $this->region = $region;
    }

    public static function PostMapping() : Vendor
    {
        $vendor = new Vendor();
        if (!empty($_POST['name']))
            $vendor->set_name($_POST['name']);

        if (!empty($_POST['shortname']))
            $vendor->set_shortname($_POST['shortname']);

        if (!empty($_POST['region']))
            $vendor->set_region($_POST['region']);

        return $vendor;
    }

    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }
    public function get_shortname() { return $this->shortname; }
    public function get_region() { return $this->region; }

    public function set_id($value) { $this->id = $value; }
    public function set_name($value) { $this->name = $value; }
    public function set_shortname($value) { $this->shortname = $value; }
    public function set_region($value) { $this->region = $value; }
}