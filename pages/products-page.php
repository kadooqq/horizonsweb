<?php
require_once('./table_modules/products-table.php');
require_once('./logics/product-logic.php');
require_once('./utils/filter.js');

$errors = array();
if (isset($_POST['id']))
    $errors = ProductLogic::delete();

$products = ProductsTable::select_all();
?>

<?php require "./components/header.php" ?>
<div class="container my-4">
    <div class="d-flex flex-row my-4 justify-content-between">
        <div class="col-md-6">
            <div class="d-flex form-inputs">
                <input class="form-control" type="text" placeholder="Поиск..." onkeyup="myFunction()" id="myInput">
                    <i class="bi bi-search mx-2"></i>
                </input>
            </div>
        </div>
        <?php if (isset($_SESSION['login_user'])) :?>
        <a type="button" href="product-form" class="btn btn-success">
            Добавить продукцию
            <i class="bi bi-plus"></i>
        </a>
        <?php endif;?>
    </div>
    <table class="table" id="myTable">
        <thead>
        <tr>
            <th style="width: 10%" scope="col">Производитель</th>
            <th style="width: 30%" scope="col">Наименование</th>
            <th style="width: 15%" scope="col">Документ</th>
            <th style="width: 15%" scope="col">Тип трубы</th>
            <th style="width: 15%" scope="col">Подтип трубы</th>
            <th style="width: 5%" scope="col">Диаметр</th>
            <th style="width: 5%" scope="col">Размер</th>
            <th style="width: 5%" scope="col">Толщина стенки трубы</th>
            <th style="width: 15%" scope="col">Маркировка стали</th>
            <th style="width: 15%" scope="col">Цена</th>
            <th style="width: 10%" scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) :?>
            <!-- Check by text -->
            <tr>
                <td class="align-middle">
                    <?=$product->get_vendor()->get_shortname() /**.', '.$product->get_vendor()->get_region()**/?>
                </td>
                <td class="align-middle justify-middle"><?= $product->get_name() ?></td>
                <td class="align-middle"><?= empty($product->get_document()) ? '?' : $product->get_document()?></td>
                <td class="align-middle"><?= $product->get_seam_type() == "SEAM" ? "Сварные" : ($product->get_seam_type() == "SEAMLESS" ? "Бесшовные" : ($product->get_seam_type() == "OTHER" ? "Другое" : $product->get_seam_type())) ?></td>
                <td class="align-middle"><?= $product->get_sub_type() == "OTHER" ? "Другое" : ($product->get_sub_type() == "BIG" ? "Трубы большого диаметра" : ($product->get_sub_type() == "PROFILE" ? "Профильные" : ($product->get_sub_type() == "ROUND" ? "Круглые" : ($product->get_sub_type() == "HOT" ? "Горячеформированные" : ($product->get_sub_type() == "COLD" ? "холодноформированные" : $product->get_sub_type()))))) ?></td>
                <td class="align-middle"><?= ($product->get_diameter_min() == 0 ? '?' : $product->get_diameter_min()).'-'.($product->get_diameter_max() == 0 ? '?' : $product->get_diameter_max())?></td>
                <td class="align-middle"><?= ($product->get_height() == 0 ? '?' : $product->get_height()).'x'.($product->get_width() == 0 ? '?' : $product->get_width())?></td>
                <td class="align-middle"><?= ($product->get_thickness_min() == 0 ? '?' : $product->get_thickness_min()).'-'.($product->get_thickness_max() == 0 ? '?' : $product->get_thickness_max())?></td>
                <td class="align-middle"><?= empty($product->get_steel_mark()) ? '?' : $product->get_steel_mark()?></td>
                <td class="align-middle"><?= $product->get_price()?></td>
                <td class="align-middle">
                    <?php if (isset($_SESSION['login_user'])) :?>
                    <div class="d-flex">
                        <a type="button" class="btn" href=<?="product-form?id=" . htmlspecialchars($product->get_id())?>>
                            <i class="bi bi-pencil-square text-success" style="font-size: 1.5rem;"></i>
                        </a>
                        <form method="post">
                            <input type="hidden" name="id" value="<?=htmlspecialchars($product->get_id()) ?>" />
                            <button type="submit" class="btn">
                                <i class="bi bi bi-x-square text-danger" style="font-size: 1.5rem;"></i>
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require "./components/footer.php" ?>
