<?php
require_once('./table_modules/wall-thickness-table.php');
require_once('./table_modules/diameter-table.php');
require_once('./table_modules/gost-table.php');
require_once('./table_modules/steel-grade-table.php');
require_once('./table_modules/mech-prop-table.php');
require_once('./table_modules/test-table.php');
require_once('./table_modules/mech-prop-tol-table.php');

require_once('./logics/requirements-logic.php');

require_once('./entities/requirements.php');

$errors = array();

$wall_thicknesses = WallThicknessTable::select_all();
$diameters = DiameterTable::select_all();
$gosts = GostTable::select_all();
$steel_grades = SteelGradeTable::select_all();
$mech_props = MechPropTable::select_all();
$tests = TestTable::select_all();

$requirements = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gost = empty($_POST["id_gost"]) ? null : GostTable::select_by_id($_POST["id_gost"]);
    $steel_grade = empty($_POST["id_steel_grade"]) ? null : SteelGradeTable::select_by_id($_POST["id_steel_grade"]);
    $diameter = empty($_POST["id_diameter"]) ? null : DiameterTable::select_by_id($_POST["id_diameter"]);
    $wall_thickness = empty($_POST["id_wall_thickness"]) ? null : WallThicknessTable::select_by_id($_POST["id_wall_thickness"]);
    $chamfer = empty($_POST["chamfer"]) ? false : $_POST["chamfer"];
    $mech_prop = MechPropTable::select_by_id($_POST["id_mech_prop"]);
    $test = TestTable::select_by_id($_POST["id_test"]);
    $mech_prop_tol = $mech_prop && $steel_grade ? MechPropTolTable::select_by_id($mech_prop->get_id(), $steel_grade->get_id()) : null;
    $mech_prop_val = $mech_prop && $_POST["mech_prop_val"] ? $_POST["mech_prop_val"] : null;
    $test_val = $test && $_POST["test_val"] ? $_POST["test_val"] : null;
    
    $errors = RequirementsLogic::validateFields($wall_thickness, 
                                                $diameter,
                                                $gost,
                                                $steel_grade,
                                                $chamfer,
                                                $mech_prop,
                                                $test,
                                                $mech_prop_tol,
                                                $mech_prop_val,
                                                $test_val);
        
    $requirements = new Requirements(0, $chamfer, $diameter, $gost, $steel_grade, $wall_thickness, $mech_prop, $mech_prop_val, $test, $test_val);
    
    if ($_POST["action"] == "totext"){
        $text = "";
        if (empty($errors)) {
            $text = RequirementsLogic::generateText($wall_thickness, 
                                                    $diameter, 
                                                    $gost,
                                                    $steel_grade,
                                                    $chamfer,
                                                    $mech_prop,
                                                    $test,
                                                    $mech_prop_tol, 
                                                    $mech_prop_val,
                                                    $test_val);

            $requirements->set_requirements_text($text);
            // header("Location: /additional_requirements");
        }
    } elseif ($_POST["action"] == "save") {
        $errors['save_btn'] = "Сохранение пока недоступно :C";
    }
    // $errors = empty($_POST["id"])? ProductLogic::create() : ProductLogic::update();

    // if (empty($errors)) {
        
        // die();
    // }
    // $requirements = Product::PostMapping();
}
// else
    // $requirements = isset($_GET["id"])? RequirementsTable::select_by_id($_GET["id"]) : $requirements;
?>

<?php require "./components/header.php"?>
<style>
    .textarea[readonly] {
        background: #fff;
    }  
</style>
<div class="container">
    <div class="row justify-content-between">      
        <div class="col<?=(isset($_SESSION['login_user'])) ? -7 : ""?> my-5 justify-content-start">
            <form method="post">
            <!-- <div class="container my-5 justify-content-center"> -->
                <div class="form-group mb-4">
                    <label for="formGost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                        </svg>
                        Нормативный документ
                    </label>
                    <select id="formGost" class="form-control" name="id_gost">
                        <?php foreach ($gosts as $gost) :?>
                            <option value="<?= $gost->get_id()?>" <?= $requirements && ($requirements->get_gost()->get_id() == $gost->get_id()) ? ' selected="selected"' : ''?>>
                                <?= $gost->get_name(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-danger"><?= $errors['gost'] ?? '' ?></div>
                </div>
                <div class="form-group mb-4">
                    <label for="formSteelGrade">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-highlighter" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.096.644a2 2 0 0 1 2.791.036l1.433 1.433a2 2 0 0 1 .035 2.791l-.413.435-8.07 8.995a.5.5 0 0 1-.372.166h-3a.5.5 0 0 1-.234-.058l-.412.412A.5.5 0 0 1 2.5 15h-2a.5.5 0 0 1-.354-.854l1.412-1.412A.5.5 0 0 1 1.5 12.5v-3a.5.5 0 0 1 .166-.372l8.995-8.07zm-.115 1.47L2.727 9.52l3.753 3.753 7.406-8.254zm3.585 2.17.064-.068a1 1 0 0 0-.017-1.396L13.18 1.387a1 1 0 0 0-1.396-.018l-.068.065zM5.293 13.5 2.5 10.707v1.586L3.707 13.5z"/>
                        </svg>
                        Марка стали
                    </label>
                    <select id="formSteelGrade" class="form-control" name="id_steel_grade">
                        <?php foreach ($steel_grades as $steel_grade) :?>
                            <option value="<?= $steel_grade->get_id()?>" <?= $requirements && ($requirements->get_steel_grade()->get_id() == $steel_grade->get_id()) ? ' selected="selected"' : ''?>>
                                <?= $steel_grade->get_name()?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-danger"><?= $errors['steel_grade'] ?? '' ?></div>
                </div>
                <div class="form-group mb-4">
                    <label for="formWallThickness">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-border-width" viewBox="0 0 16 16">
                            <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5"/>
                        </svg>
                        Толщина стенки
                    </label>
                    <select id="formWallThickness" class="form-control" name="id_wall_thickness">
                        <?php foreach ($wall_thicknesses as $wall_thickness) :?>
                            <option value="<?= $wall_thickness->get_id()?>" <?= $requirements && ($requirements->get_wall_thickness()->get_id() == $wall_thickness->get_id()) ? ' selected="selected"' : ''?>>
                                <?= $wall_thickness->get_value()?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-danger"><?= $errors['wall_thickness'] ?? '' ?></div>
                </div>
                <div class="form-group mb-4">
                    <label for="formDiameter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-record" viewBox="0 0 16 16">
                            <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10"/>
                        </svg>
                        Диаметер
                    </label>
                    <select id="formDiameter" class="form-control" name="id_diameter">
                        <?php foreach ($diameters as $diameter) :?>
                            <option value="<?= $diameter->get_id()?>" <?= $requirements && ($requirements->get_diameter()->get_id() == $diameter->get_id()) ? ' selected="selected"' : ''?>>
                                <?= $diameter->get_value()?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-danger"><?= $errors['diameter'] ?? '' ?></div>
                </div>
                <div class="form-group mb-4">
                    <div class="form-control-plain">
                        <input class="form-check-input" type="checkbox" name="chamfer" <?= $requirements && $requirements->get_chamfer() ? 'checked=checked' : ''?> id="id_chamfer">
                        <label class="form-check-label" for="chamfer">
                            Фаска
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tencent-qq" viewBox="0 0 16 16">
                                <path d="M6.048 3.323c.022.277-.13.523-.338.55-.21.026-.397-.176-.419-.453s.13-.523.338-.55c.21-.026.397.176.42.453Zm2.265-.24c-.603-.146-.894.256-.936.333-.027.048-.008.117.037.15.045.035.092.025.119-.003.361-.39.751-.172.829-.129l.011.007c.053.024.147.028.193-.098.023-.063.017-.11-.006-.142-.016-.023-.089-.08-.247-.118"/>
                                <path d="M11.727 6.719c0-.022.01-.375.01-.557 0-3.07-1.45-6.156-5.015-6.156S1.708 3.092 1.708 6.162c0 .182.01.535.01.557l-.72 1.795a26 26 0 0 0-.534 1.508c-.68 2.187-.46 3.093-.292 3.113.36.044 1.401-1.647 1.401-1.647 0 .979.504 2.256 1.594 3.179-.408.126-.907.319-1.228.556-.29.213-.253.43-.201.518.228.386 3.92.246 4.985.126 1.065.12 4.756.26 4.984-.126.052-.088.088-.305-.2-.518-.322-.237-.822-.43-1.23-.557 1.09-.922 1.594-2.2 1.594-3.178 0 0 1.041 1.69 1.401 1.647.168-.02.388-.926-.292-3.113a26 26 0 0 0-.534-1.508l-.72-1.795ZM9.773 5.53a.1.1 0 0 1-.009.096c-.109.159-1.554.943-3.033.943h-.017c-1.48 0-2.925-.784-3.034-.943a.1.1 0 0 1-.018-.055q0-.022.01-.04c.13-.287 1.43-.606 3.042-.606h.017c1.611 0 2.912.319 3.042.605m-4.32-.989c-.483.022-.896-.529-.922-1.229s.344-1.286.828-1.308c.483-.022.896.529.922 1.23.027.7-.344 1.286-.827 1.307Zm2.538 0c-.484-.022-.854-.607-.828-1.308.027-.7.44-1.25.923-1.23.483.023.853.608.827 1.309-.026.7-.439 1.251-.922 1.23ZM2.928 8.99q.32.063.639.117v2.336s1.104.222 2.21.068V9.363q.49.027.937.023h.017c1.117.013 2.474-.136 3.786-.396.097.622.151 1.386.097 2.284-.146 2.45-1.6 3.99-3.846 4.012h-.091c-2.245-.023-3.7-1.562-3.846-4.011-.054-.9 0-1.663.097-2.285"/>
                            </svg>
                        </label>
                    </div>
                    <div class="text-danger"><?= $errors['chamfer'] ?? '' ?></div>
                </div>
                <div class="row form-group mb-4">
                    <div class="col-9">
                        <label for="formMechProp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench" viewBox="0 0 16 16">
                                <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                            </svg>
                            Механические свойства
                        </label>
                        <select id="formMechProp" class="form-control" name="id_mech_prop">
                            <option value="-1">-</option>
                            <?php foreach ($mech_props as $mech_prop) :?>
                                <option value="<?= $mech_prop->get_id()?>" <?= $requirements && $requirements->get_mech_prop() && ($requirements->get_mech_prop()->get_id() == $mech_prop->get_id()) ? ' selected="selected"' : ''?>>
                                    <?= $mech_prop->get_name()?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger"><?= $errors['mech_prop'] ?? '' ?></div>
                    </div>
                    <div class="col-3">
                        <label for="formMechPropVal">
                        </label>
                        <input type="number" class="form-control" id="mech_prop_val" placeholder="Значение" min="0"
                            name="mech_prop_val" step="0.25" <?= $requirements && $requirements->get_mech_prop() && $requirements->get_mech_prop_val() ? ' value="'.$requirements->get_mech_prop_val().'"' : ''?>>
                        <div class="text-danger"><?= $errors['mech_prop_val'] ?? '' ?></div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <div class="col-9">
                        <label for="formTest">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hammer" viewBox="0 0 16 16">
                                <path d="M9.972 2.508a.5.5 0 0 0-.16-.556l-.178-.129a5 5 0 0 0-2.076-.783C6.215.862 4.504 1.229 2.84 3.133H1.786a.5.5 0 0 0-.354.147L.146 4.567a.5.5 0 0 0 0 .706l2.571 2.579a.5.5 0 0 0 .708 0l1.286-1.29a.5.5 0 0 0 .146-.353V5.57l8.387 8.873A.5.5 0 0 0 14 14.5l1.5-1.5a.5.5 0 0 0 .017-.689l-9.129-8.63c.747-.456 1.772-.839 3.112-.839a.5.5 0 0 0 .472-.334"/>
                            </svg>
                            Испытания
                        </label>
                        <select id="formTest" class="form-control" name="id_test">
                            <option value="-1">-</option>
                            <?php foreach ($tests as $test) :?>
                                <option value="<?= $test->get_id()?>" <?= $requirements && $requirements->get_test() && ($requirements->get_test()->get_id() == $test->get_id()) ? ' selected="selected"' : ''?>>
                                    <?= $test->get_name()?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger"><?= $errors['test'] ?? '' ?></div>
                    </div>
                    <div class="col-3">
                        <label for="formTestVal">
                        </label>
                        <input type="number" class="form-control" id="test_val" placeholder="Температура" min="-273"
                            name="test_val" step="0.25" <?= $requirements && $requirements->get_test() && $requirements->get_test_val() ? ' value="'.$requirements->get_test_val().'"' : ''?>>
                        <div class="text-danger"><?= $errors['test_val'] ?? '' ?></div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <div method="post" class="d-flex justify-content-end">
                        <input type="hidden" name="id" value="<?= isset($_REQUEST["id"]) ? htmlspecialchars($_REQUEST["id"]) : '' ?>" />
                        <button type="submit" name="action" class="btn btn-outline-dark" value="totext">Перевести в требования</button>
                        <?php if (isset($_SESSION['login_user'])) :?>
                            <button type="submit" name="action", id="save_btn", class="btn btn-outline-dark mx-2" value="save">Сохранить</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <div class="d-flex text-danger justify-content-end"><?= $errors['save_btn'] ?? '' ?></div>
            </form>
        </div>
        <?php if (isset($_SESSION['login_user'])) :?>
        <div class="col-4 my-5 justify-content-end">
            <div class="flex-row my-4 justify-content-end">
                <div class="d-flex form-inputs">
                    <span class="input-group-text" id="basic_addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                        </svg>
                    </span>
                    <input class="form-control" type="text" placeholder="Поиск по названию..." id="myInput">
                    </input>
                </div>
            </div>
            <div class="flex-row justify-content-end">
                <table class="table table-bordered" id="myTable">
                    <thead>
                    <tr>
                        <th style="width: 90%" scope="col">Дополнительные требования</th>
                        <th style="width: 10%" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                Требования ВТЗ 20.05.2020
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                                Требования СТЗ 03.02.2022
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <textarea readonly class="textarea" id="textarea" rows="8"><?=$requirements ? $requirements->get_requirements_text() : ""; ?></textarea>
    </div>
</div>

<?php require "./components/footer.php" ?>
