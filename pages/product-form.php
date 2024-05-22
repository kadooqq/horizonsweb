<?php
require_once('./table_modules/products-table.php');
require_once('./table_modules/vendors-table.php');
require_once('./logics/product-logic.php');

$product = new Product();
$vendors = VendorsTable::select_all();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = empty($_POST["id"])? ProductLogic::create() : ProductLogic::update();

    if (empty($errors)){
        header("Location: products");
        die();
    }
    $product = Product::PostMapping();
}
else
    $product = isset($_GET["id"])? ProductsTable::select_by_id($_GET["id"]) : $product;
?>

<?php require "./components/header.php" ?>
<div class="container my-5">
    <div class="my-3">
        <a type="button" href="/products" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i>
            Назад
        </a>
    </div>
    <form enctype="multipart/form-data" method="post">
        <div class="form-group mb-4">
            <label for="formName">Наименование продукции *</label>
            <input type="text" class="form-control" id="formName" placeholder="Укажите название продукции..."
                    name="name" value="<?= $product->get_name() ?? "" ?>" >
            <div class="text-danger"><?= $errors['name'] ?? '' ?></div>
        </div>
        <div class="form-group mb-4">
            <label for="formSeamType">Тип шва *</label>
            <input type="text" class="form-control" id="formSeamType" placeholder="Укажите тип шва..."
                    name="seam_type" value="<?= $product->get_seam_type() ?? "" ?>" >
            <div class="text-danger"><?= $errors['seam_type'] ?? '' ?></div>
        </div>
        <div class="form-group mb-4">
            <label for="formSubType">Подтип трубы *</label>
            <input type="text" class="form-control" id="formSubType" placeholder="Укажите подтип трубы..."
                    name="sub_type" value="<?= $product->get_sub_type() ?? "" ?>" >
            <div class="text-danger"><?= $errors['sub_type'] ?? '' ?></div>
        </div>
        <div class="form-group mb-4">
            <label for="formDocument">Нормативно-технический документ *</label>
            <input type="text" class="form-control" id="formDocument" placeholder="Укажите НТД..."
                    name="document" value="<?= $product->get_document() ?? "" ?>" >
            <div class="text-danger"><?= $errors['document'] ?? '' ?></div>
        </div>
        <div class="row">
            <div class="col form-group mb-4">
                <label for="formHeight">Длина трубы *</label>
                <input type="number" class="form-control" id="formHeight" placeholder="Укажите длину в миллиметрах" min="0"
                        name="height" value="<?= $product->get_thickness_min() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['height'] ?? '' ?></div>
            </div>
            <div class="col form-group mb-4">
                <label for="formWidth">Ширина трубы *</label>
                <input type="number" class="form-control" id="formWidth" placeholder="Укажите ширину в миллиметрах" min="0"
                        name="width" value="<?= $product->get_thickness_max() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['width'] ?? '' ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col form-group mb-4">
                <label for="formDiameterMin">Минимальный диаметр трубы *</label>
                <input type="number" class="form-control" id="formDiameterMin" placeholder="Укажите диаметер в миллиметрах" min="0"
                        name="diameter_min" value="<?= $product->get_diameter_min() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['diameter_min'] ?? '' ?></div>
            </div>
            <div class="col form-group mb-4">
                <label for="formDiameterMax">Максимальный диаметр трубы *</label>
                <input type="number" class="form-control" id="formDiameterMax" placeholder="Укажите диаметер в миллиметрах" min="0"
                        name="diameter_max" value="<?= $product->get_diameter_max() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['diameter_max'] ?? '' ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col form-group mb-4">
                <label for="formThicknessMin">Минимальная толщина стенки трубы *</label>
                <input type="number" class="form-control" id="formThicknessMin" placeholder="Укажите толщину в миллиметрах" min="0"
                        name="thickness_min" value="<?= $product->get_thickness_min() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['thickness_min'] ?? '' ?></div>
            </div>
            <div class="col form-group mb-4">
                <label for="formThicknessMax">Максимальная толщина стенки трубы *</label>
                <input type="number" class="form-control" id="formThicknessMax" placeholder="Укажите толщину в миллиметрах" min="0"
                        name="thickness_max" value="<?= $product->get_thickness_max() ?? 0 ?>" >
                <div class="text-danger"><?= $errors['thickness_max'] ?? '' ?></div>
            </div>
        </div>
        <div class="form-group mb-4">
            <label for="formSteelMark">Маркировка стали трубы *</label>
            <input type="text" class="form-control" id="formSteelMark" placeholder="Укажите маркировку стали"
                    name="steel_mark" value="<?= $product->get_steel_mark() ?? "" ?>" >
            <div class="text-danger"><?= $errors['steel_mark'] ?? '' ?></div>
        </div>
        <div class="form-group mb-4">
            <label for="formVendor">Изготовитель *</label>
            <select id="formVendor" class="form-control" name="id_vendor">
                <?php foreach ($vendors as $vendor) :?>
                    <option value="<?= $vendor->get_id()?>"
                        <?= ($product->get_vendor()->get_id() == $vendor->get_id()) ? ' selected="selected"' : ''?>>
                        <?= $vendor->get_shortname()?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="text-danger"><?= $errors['id_vendor'] ?? '' ?></div>
        </div>
        <div class="col form-group mb-4">
            <label for="formPrice">Цена *</label>
            <input type="number" class="form-control" id="formPrice" placeholder="Укажите цену" min="0"
                    name="price" value="<?= $product->get_thickness_max() ?? 0 ?>" >
            <div class="text-danger"><?= $errors['price'] ?? '' ?></div>
        </div>
        <input type="hidden" name="id" value="<?= isset($_REQUEST["id"]) ? htmlspecialchars($_REQUEST["id"]) : '' ?>" />
        <button type="submit" class="btn col-md-2 btn-success my-3">
            Сохранить
        </button>
    </form>
</div>
<?php require "./components/footer.php" ?>
