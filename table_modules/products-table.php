<?php
require_once('./core/psql_db.php');
require_once('./entities/product-class.php');
require_once('./entities/vendor-class.php');

class ProductsTable {
    public static string $table_name = "products";

    private static function _from_row(mixed $row) : Product {
        $product = new Product();
        $product->set_id($row['product_id'] ?? 0);
        $product->set_name($row['product_name'] ?? "");
        $product->set_seam_type($row['product_seamtype'] ?? "Не указан");
        $product->set_sub_type($row['product_subtype'] ?? "Не указан");
        $product->set_document($row['product_document'] ?? "Не указан");
        $product->set_diameter_min($row['product_diametermin'] ?? 0);
        $product->set_diameter_max($row['product_diametermax'] ?? 0);
        $product->set_width($row['product_width'] ?? 0);
        $product->set_height($row['product_height'] ?? 0);
        $product->set_thickness_min($row['product_thicknessmin'] ?? 0);
        $product->set_thickness_max($row['product_thicknessmax'] ?? 0);
        $product->set_steel_mark($row['product_steelmark'] ?? "Не указана");
        $product->set_price($row['product_price'] ?? 0);
        $product->set_status($row['product_status'] ?? "Не указан");

        $vendor = new Vendor();
        $vendor->set_id($row['vendor_id'] ?? 0);
        $vendor->set_name($row['vendor_name'] ?? "");
        $vendor->set_shortname($row['vendor_shortname'] ?? "");
        $vendor->set_region($row['vendor_region'] ?? "");

        $product->set_vendor($vendor);
        return $product;
    }

    public static function select_all($limit = null): array
    {
        $query = Database::prepare("SELECT * FROM vendors JOIN products ON vendors.vendor_id = products.vendor_id");
        $query->execute();
        $result = $query->fetchAll();

        $array_products = array();

        foreach ($result as $row) {
            $array_products[] = self::_from_row($row);
        }

        return $array_products;
    }

    public static function select_by_id(int $id) : Product | null {
        $query = Database::prepare("SELECT FROM vendors join products on vendors.vendor_id = products.vendor_id WHERE product_id= :id;");
        $query->bindValue(":id", $id);
        $query->execute();

        $result = $query->fetchAll();

        if (!count($result))
            return null;
        return self::_from_row($result[0]);
    }

    public static function create(Product $product) {
        $query = Database::prepare("INSERT INTO ".static::$table_name.
            " (vendor_id,product_name,product_seamType,product_subType,product_document,product_diameterMin,product_diameterMax,product_width,product_height,product_thicknessMin,product_thicknessMax,product_steelMark,product_price,product_status)".
            " VALUES (:vendor_id, :name, :seam_type, :sub_type, :document, :diameter_min, :diameter_max, :width, :height, :thickness_min, :thickness_max, :steel_mark, :price, :status);");

        $query->bindValue(":vendor_id", $product->get_vendor()->get_id());
        echo $product->get_vendor()->get_id();
        $query->bindValue(":name", $product->get_name());
        $query->bindValue(":seam_type", $product->get_seam_type());
        $query->bindValue(":sub_type", $product->get_sub_type());
        $query->bindValue(":document", $product->get_document());
        $query->bindValue(":diameter_min", $product->get_diameter_min());
        $query->bindValue(":diameter_max", $product->get_diameter_max());
        $query->bindValue(":width", $product->get_width()); // TODO
        $query->bindValue(":height", $product->get_height()); // TODO
        $query->bindValue(":thickness_min", $product->get_thickness_min());
        $query->bindValue(":thickness_max", $product->get_thickness_max());
        $query->bindValue(":steel_mark", $product->get_steel_mark());
        $query->bindValue(":price", $product->get_price());
        $query->bindValue(":status", $product->get_status());
        
        if(!$query->execute()){
            throw new PDOException("error creating a product");
        }
    }

    public static function update(Product $product) {
        $query = Database::prepare("UPDATE products SET vendor_id = :vendor_id , product_name = :name, product_seamType = :seam_type, product_subType = :sub_type, product_document = :document, product_diameterMin = :diameter_min, product_diameterMax = :diameter_max, product_width = :width, product_height = :height, product_thicknessMin = :thickness_min, product_thicknessMax = :thickness_max, product_steelMark = :steel_mark, product_price = :price, product_status = :status".
            " WHERE product_id = :id;");

        $query->bindValue(":id", $product->get_id());
        $query->bindValue(":name", $product->get_name());
        $query->bindValue(":seam_type", $product->get_seam_type());
        $query->bindValue(":sub_type", $product->get_sub_type());
        $query->bindValue(":document", $product->get_document());
        $query->bindValue(":diameter_min", $product->get_diameter_min());
        $query->bindValue(":diameter_max", $product->get_diameter_max());
        $query->bindValue(":width", $product->get_width());
        $query->bindValue(":height", $product->get_height());
        $query->bindValue(":thickness_min", $product->get_thickness_min());
        $query->bindValue(":thickness_max", $product->get_thickness_max());
        $query->bindValue(":steel_mark", $product->get_steel_mark());
        $query->bindValue(":price", $product->get_price());
        $query->bindValue(":status", $product->get_status());
        $query->bindValue(":vendor_id", $product->get_vendor()->get_id());
    
        if(!$query->execute()){
            throw new PDOException("error editing product");
        }
    }

    public static function remove_by_id($id) {
        $query = Database::prepare("DELETE FROM ".static::$table_name." WHERE product_id = :id");
        $query->bindValue(":id", $id);

        if(!$query->execute()){
            throw new PDOException("error deleting a product");
        }
    }
}