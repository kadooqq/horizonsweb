<?php
require_once('./table_modules/vendors-table.php');
require_once('./logics/vendor-logic.php');

$vendor = new Vendor();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = empty($_POST["id"])? VendorLogic::create() : VendorLogic::update();

    if (empty($errors)){
        header("Location: vendors");
        die();
    }
    $vendor = Vendor::PostMapping();
}
else
    $vendor = isset($_GET["id"])? VendorsTable::select_by_id($_GET["id"]) : $vendor;
?>

<?php require "./components/header.php" ?>
<div class="container my-5">
    <div class="my-3">
        <a type="button" href="/vendors" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i>
            Назад
        </a>
    </div>
    <form enctype="multipart/form-data" method="post">
        <div class="form-group mb-4">
            <label for="formName">Наименование компании *</label>
            <input type="text" class="form-control" id="formName" placeholder="Укажите название компании..."
                    name="name" value="<?= $vendor->get_name() ?? "" ?>" >
            <div class="text-danger"><?= $errors['name'] ?? '' ?></div>
        </div>
        <div class="form-group mb-4">
            <label for="formShortname">Краткое наименование компании *</label>
            <input type="text" class="form-control" id="formShortname" placeholder="Укажите краткое название компании..."
                    name="shortname" value="<?= $vendor->get_shortname() ?? "" ?>" >
            <div class="text-danger"><?= $errors['shortname'] ?? '' ?></div>
        </div>
        <input type="hidden" name="id" value="<?= isset($_REQUEST["id"]) ? htmlspecialchars($_REQUEST["id"]) : '' ?>" />
        <button type="submit" class="btn col-md-2 btn-success my-3">
            Сохранить
        </button>
    </form>
</div>
<?php require "./components/footer.php" ?>