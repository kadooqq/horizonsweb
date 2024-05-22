<?php
class VendorLogic {

    // Возвращает список ошибок полей
    static function validateVendorField(): array
    {
        $errors = array();

        if (empty($_POST["name"])) {
            $errors["name"] = "Недопустимое значение имени";
        }

        if (empty($_POST["shortname"])){
            $errors["shortname"] = "Недопустимое значение фамилии";
        }

        return $errors;
    }

    static function create(): array
    {
        $errors = self::validateVendorField();

        if (empty($errors)) {
            $vendor = Vendor::PostMapping();

            VendorsTable::create($vendor);
        }

        return $errors;
    }

    static function update(): array
    {
        $errors = self::validateVendorField();

        if (isset($_POST["id"]) && ($_POST["id"] == 0)) {
            $errors["id"] = "Недопустимое значение id";
        }

        if (empty($errors)) {
            $vendor = Vendor::PostMapping();
            $vendor->set_id($_POST["id"]);
            VendorsTable::update($vendor);
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
            VendorsTable::remove_by_id($_POST["id"]);
        }

        return $errors;
    }
}