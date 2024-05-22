<?php
class ProductLogic {

    // Возвращает список ошибок полей
    static function validateProductField(): array
    {
        $errors = array();

        if (empty($_POST["name"])) {
            $errors["name"] = "Недопустимое значение имени";
        }

        if (empty($_POST["seam_type"])){
            $errors["seam_type"] = "Недопустимое название шва";
        }

        if (empty($_POST["sub_type"])){
            $errors["sub_type"] = "Недопустимое название подтипа";
        }

        if (empty($_POST["sub_type"])){
            $errors["sub_type"] = "Недопустимое название подтипа";
        }

        if (empty($_POST["diameter_min"]) || $_POST["diameter_min"] < 0){
                $errors["diameter_min"] = "Недопустимое значение минимального диаметра";
        }

        if (empty($_POST["diameter_max"]) || $_POST["diameter_max"] < 0 || $_POST["diameter_max"] < $_POST["diameter_min"]){
            $errors["diameter_min"] = "Недопустимое значение максимального диаметра";
        }

        if (empty($_POST["thickness_min"]) || $_POST["thickness_min"] < 0){
            $errors["thickness_min"] = "Недопустимое значение минимальной толщины";
        }

        if (empty($_POST["thickness_max"]) || $_POST["thickness_max"] < 0 || $_POST["thickness_max"] < $_POST["thickness_min"]){
            $errors["thickness_max"] = "Недопустимое значение максимальной толщины";
        }

        if (empty($_POST["height"]) || $_POST["height"] < 0){
            $errors["height"] = "Недопустимое значение длины";
        }

        if (empty($_POST["width"]) || $_POST["width"] < 0){
            $errors["width"] = "Недопустимое значение ширины";
        }

        if (empty($_POST["price"]) || $_POST["price"] < 0){
            $errors["price"] = "Недопустимое значение цены";
        }

        if (empty($_POST["steel_mark"])){
            $errors["steel_mark"] = "Недопустимая маркировка стали";
        }

        if (empty($_POST["id_vendor"])) {
            $errors["id_vendor"] = "Не выбран производитель";
        }

        return $errors;
    }

    static function create(): array
    {
        $errors = self::validateProductField();

        if (empty($errors)) {
            $products = Product::PostMapping();
            ProductsTable::create($products);
        }

        return $errors;
    }

    static function update(): array
    {
        $errors = self::validateProductField();

        if (isset($_POST["id"]) && ($_POST["id"] == 0)) {
            $errors["id"] = "Недопустимое значение id";
        }

        if (empty($errors)) {
            $products = Product::PostMapping();

            $products->set_id($_POST["id"]);
            ProductsTable::update($products);
        }

        return $errors;
    }

    static function delete(): array
    {
        $errors = array();
        if (!isset($_POST["id"]) || ($_POST["id"] == 0)) {
            $errors["id"] = "Недопустимое значение id";
        }
        else {
            ProductsTable::remove_by_id($_POST["id"]);
        }

        return $errors;
    }
}