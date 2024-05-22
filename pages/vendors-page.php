<?php
require_once('./table_modules/vendors-table.php');
require_once('./logics/vendor-logic.php');
$errors = array();
if (isset($_POST['id']))
    $errors = VendorLogic::delete();

$vendors = VendorsTable::select_all();
?>

<?php require "./components/header.php"?>
    <div class="container my-5 justify-content-center">
        <div class="d-flex flex-row my-4 justify-content-between">
            <div class="col-md-6">
                <div class="d-flex form-inputs">
                    <input class="form-control" type="text" placeholder="Поиск по имени..." onkeyup="myFunction()" id="myInput">
                        <i class="bi bi-search mx-2"></i>
                    </input>
                </div>
            </div>
            <?php if (isset($_SESSION['login_user'])) :?>
            <a type="button" href="/vendor-form" class="btn btn-success mx-5">
                Добавить компанию
                <i class="bi bi-plus"></i>
            </a>
            <?php endif;?>
        </div>

        <div class="row row-cols-4">
            <?php foreach ($vendors as $vendor) :?>
                <div class="card mb-4 mx-3 mx-0 box-shadow" style="width: 18rem;">
                    <div class="d-flex flex-wrap justify-content-between align-items-center my-1">
                        <h4 class="font-weight-normal"><?php echo $vendor->get_shortname() ?></h4>
                        <?php if (isset($_SESSION['login_user'])) :?>
                        <div class="px-0 d-flex">
                            <a type="button" class="btn p-1"
                               href=<?php echo "/vendor-form?id=" . htmlspecialchars($vendor->get_id()) ?>>
                                <i class="bi bi-pencil-square text-success" style="font-size: 1.5rem;"></i>
                            </a>
                            <form method="post">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($vendor->get_id()) ?>" />
                                <button type="submit" class="btn p-1">
                                    <i class="bi bi bi-x-square text-danger" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <ul class="my-1">
                            <h5><h5\>
                            <li><?php echo $vendor->get_name() ?></li>
                            <li><?php echo ($vendor->get_region() ? $vendor->get_region() : "Регион не задан")  ?></li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require "./components/footer.php" ?>