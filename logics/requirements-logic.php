<?php

class RequirementsLogic {

    // Возвращает список ошибок полей
    static function validateFields(WallThickness $wall_thickness = null, 
                                    Diameter $diameter = null, 
                                    Gost $gost = null, 
                                    SteelGrade $steel_grade = null,
                                    bool $chamfer = false,
                                    MechProp $mech_prop = null,
                                    Test $test = null,
                                    MechPropTol $mech_prop_tol = null,
                                    float $mech_prop_val = null,
                                    float $test_val = null
                                    ): array
    {
        $errors = array();

        if ($wall_thickness == null) {
            $errors["wall_thickness"] = "Необходимо выбрать толщину стенок";
        }
        if ($diameter == null) {
            $errors["diameter"] = "Необходимо выбрать диаметр";
        }
        if ($gost == null) {
            $errors["gost"] = "Необходимо выбрать нормативный документ";
        }
        if ($steel_grade == null) {
            $errors["steel_grade"] = "Необходимо выбрать марку стали";
        }

        // Tests
        if ($test && $diameter && $wall_thickness && $test->get_name() == "Раздача") {
            $values_errors = array();
            if ($diameter->get_value() > 159) {
                $values_errors[] = "диаметр <= 159";
            }
            if ($wall_thickness->get_value() > 8) {
                $values_errors[] = "толщина стенки <= 8";
            }
        }
        elseif ($test && $diameter && $wall_thickness && $test->get_name() == "Сплющивание") {
            $values_errors = array();
            if ($wall_thickness->get_value() > 10) {
                $values_errors[] = "толщина стенки <= 10";
            }
            if ($wall_thickness->get_value()/$diameter->get_value()*100 > 15) {
                $values_errors[] = "стенка/диаметр*100 <= 15";
            }
        }
        
        if (!empty($values_errors)) {
            $errors['test'] = "Допустимые значения для испытания ".$test->get_name().": ".implode(', ', $values_errors);
        }
        if ($test && $test->get_id() == 1 && !$test_val)
            $errors['test_val'] = 'Укажите температуру проведения испытаний';

        // Mech props
        if ($mech_prop && $mech_prop_tol && $steel_grade && $mech_prop_tol->get_min() > $mech_prop_val) {
            $errors['mech_prop_val'] = "Значение должно быть больше указанного в ГОСТе";
        }

        return $errors;
    }

    static function generateText(WallThickness $wall_thickness = null, 
                                    Diameter $diameter = null, 
                                    Gost $gost = null, 
                                    SteelGrade $steel_grade = null,
                                    bool $chamfer = false,
                                    MechProp $mech_prop = null,
                                    Test $test = null,
                                    MechPropTol $mech_prop_tol = null,
                                    float $mech_prop_val = null,
                                    float $test_val = null
                                    ): string
    {
        $text = "";

        $values_text = "Номенклатура: \n";
        $values_text = $values_text.$diameter->get_value()." x ".$wall_thickness->get_value();
        $values_text = $values_text." ст".$steel_grade->get_name()." ".$gost->get_name();

        $tests_text = "";
        
        if ($test) {
            $tests_text = "\n\nИспытания:\n";
            
            $gost_text = "";
            if ($test->get_id() == 1) {
                $gost_text = "ГОСТ 9454-78. Для испытаний на ударный изгиб отбирают 2 трубы от партии,";
                $gost_text = $gost_text." от каждой трубы отбирают по 3 образца, значение ударной вязкости рассчитывают";
                $gost_text = $gost_text." как среднее арифметическое значение результатов испытаний 3-х образцов.";
                $gost_text = $gost_text." Ударная вязкость при Т=".$test_val." грС, не менее ? Дж/см^2.";
            } elseif ($test->get_id() == 2) {
                $gost_text = "ГОСТ 8694.";
            } elseif ($test->get_id() == 3) {
                $gost_text = "ГОСТ 8695.";
            } elseif ($test->get_id() == 4) {
                $gost_text = "ГОСТ 3728.";
            }
            $test_text = "Испытание \"".$test->get_name()."\" по ".$gost_text;
            $tests_text = $tests_text.$test_text;
        }

        $text = $values_text.$tests_text;
        return $text;
    }

    // static function create(): array
    // {
    //     $errors = self::validateProductField();

    //     if (empty($errors)) {
    //         $products = Product::PostMapping();
    //         ProductsTable::create($products);
    //     }

    //     return $errors;
    // }

    // static function update(): array
    // {
    //     $errors = self::validateProductField();

    //     if (isset($_POST["id"]) && ($_POST["id"] == 0)) {
    //         $errors["id"] = "Недопустимое значение id";
    //     }

    //     if (empty($errors)) {
    //         $products = Product::PostMapping();

    //         $products->set_id($_POST["id"]);
    //         ProductsTable::update($products);
    //     }

    //     return $errors;
    // }

    // static function delete(): array
    // {
    //     $errors = array();
    //     if (!isset($_POST["id"]) || ($_POST["id"] == 0)) {
    //         $errors["id"] = "Недопустимое значение id";
    //     }
    //     else {
    //         ProductsTable::remove_by_id($_POST["id"]);
    //     }

    //     return $errors;
    // }
}
