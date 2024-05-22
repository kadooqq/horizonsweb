<?php

class Product {
    private int $id = 0;
    private string $name = "";
    private string $seam_type = "";
    private string $sub_type = "";
    private string $document = "";
    private float $diameter_min = 0;
    private float $diameter_max = 0;
    private float $width = 0;
    private float $height = 0;
    private float $thickness_min = 0;
    private float $thickness_max = 0;
    private string $steel_mark = "";
    private float $price = 0;
    private string $status = "";
    private Vendor $vendor;

    public function __construct($id = 0, $name = "", $seam_type = "", $sub_type = "Не указана",
    $diameter_min = 0, $diameter_max = 0, $width = 0, $height = 0, $price = 0, $status = "Не указан", $thickness_min = 0, $thickness_max = 0, $document="Не указан", $steel_mark="", $vendor = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->seam_type = $seam_type;
        $this->sub_type = $sub_type;
        $this->document = $document;
        $this->diameter_min = $diameter_min;
        $this->diameter_max = $diameter_max;
        $this->width = $width;
        $this->height = $height;
        $this->thickness_min = $thickness_min;
        $this->thickness_max = $thickness_max;
        $this->steel_mark = $steel_mark;
        $this->price = $price;
        $this->status = $status;
        $this->vendor = $vendor ?? new Vendor();
    }

    public static function PostMapping() : Product
    {
        $product = new product();
        if (!empty($_POST['name']))
            $product->set_name($_POST['name']);

        if (!empty($_POST['seam_type']))
            $product->set_seam_type($_POST['seam_type']);

        if (!empty($_POST['sub_type']))
            $product->set_sub_type($_POST['sub_type']);

        if (!empty($_POST['document']))
            $product->set_document($_POST['document']);

        if (!empty($_POST['height']))
            $product->set_height($_POST['height']);

        if (!empty($_POST['width']))
            $product->set_width($_POST['width']);

        if (!empty($_POST['diameter_min']))
            $product->set_diameter_min($_POST['diameter_min']);

        if (!empty($_POST['diameter_max']))
            $product->set_diameter_max($_POST['diameter_max']);

        if (!empty($_POST['thickness_min']))
            $product->set_thickness_min($_POST['thickness_min']);

        if (!empty($_POST['thickness_max']))
            $product->set_thickness_max($_POST['thickness_max']);

        if (!empty($_POST['steel_mark']))
            $product->set_steel_mark($_POST['steel_mark']);

        if (!empty($_POST['id_vendor'])) {
            $vendor = new Vendor();
            $vendor->set_id($_POST['id_vendor']);
            $product->set_vendor($vendor);
        }

        if (!empty($_POST['price']))
            $product->set_price($_POST['price']);

        return $product;
    }

    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }
    public function get_seam_type() { return $this->seam_type; }
    public function get_sub_type() { return $this->sub_type; }
    public function get_document() { return $this->document; }
    public function get_diameter_min() { return $this->diameter_min; }
    public function get_diameter_max() { return $this->diameter_max; }
    public function get_thickness_min() { return $this->thickness_min; }
    public function get_thickness_max() { return $this->thickness_max; }
    public function get_width() { return $this->width; }
    public function get_height() { return $this->height; }
    public function get_price() { return $this->price; }
    public function get_status() { return $this->status; }
    public function get_vendor() { return $this->vendor; }
    public function get_steel_mark() { return $this->steel_mark; }

    public function set_id($value) { $this->id = $value; }
    public function set_name($value) { $this->name = $value; }
    public function set_seam_type($value) { $this->seam_type = $value; }
    public function set_sub_type($value) { $this->sub_type = $value; }
    public function set_document($value) { $this->document = $value; }
    public function set_diameter_min($value) { $this->diameter_min = $value; }
    public function set_diameter_max($value) { $this->diameter_max = $value; }
    public function set_width($value) { $this->width = $value; }
    public function set_height($value) { $this->height = $value; }
    public function set_thickness_min($value) { $this->thickness_min = $value; }
    public function set_thickness_max($value) { $this->thickness_max = $value; }
    public function set_steel_mark($value) { $this->steel_mark = $value; }
    public function set_price($value) { $this->price = $value; }
    public function set_status($value) { $this->status = $value; }
    public function set_vendor($value) { $this->vendor = $value; }
}