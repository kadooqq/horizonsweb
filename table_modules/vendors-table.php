<?php
require_once('./core/psql_db.php');
require_once('./entities/vendor-class.php');

class VendorsTable {
    public static string $table_name = "vendors";

    private static function _from_row(mixed $row) : Vendor {
        $vendor = new Vendor();
        $vendor->set_id($row['vendor_id'] ?? 0);
        $vendor->set_name($row['vendor_name'] ?? "");
        $vendor->set_region($row['vendor_region'] ?? "");
        $vendor->set_shortname($row['vendor_shortname'] ?? "");

        return $vendor;
    }

    public static function select_all($limit = null): array
    {
        $query =  Database::prepare("select * from ".static::$table_name.";");
        $query->execute();
        $result = $query->fetchAll();
        $array_vendors = array();

        foreach ($result as $row) {
            $array_vendors[] = self::_from_row($row);
        }

        return $array_vendors;
    }

    public static function select_by_id(int $id) : Vendor | null {
        $query = Database::prepare("SELECT * FROM vendors WHERE vendor_id= :id;");
        $query->bindValue(":id", $id);
        $query->execute();

        $result = $query->fetchAll();

        if (!count($result))
            return null;
        return self::_from_row($result[0]);
    }

    public static function create(Vendor $vendor) {
        $query = Database::prepare("INSERT INTO vendors (vendor_name, vendor_shortname, vendor_region) VALUES (:name, :shortname, :region);");

        $query->bindValue(":name", $vendor->get_name());
        $query->bindValue(":shortname", $vendor->get_shortname());
        $query->bindValue(":region", $vendor->get_region());

        if(!$query->execute()){
            throw new PDOException("error creating a vendor");
        }
    }

    public static function update(Vendor $vendor) {
        $query = Database::prepare("UPDATE vendors SET vendor_name = :name, vendor_shortname = :shortname, vendor_region = :region WHERE vendor_id = :id;");

        $query->bindValue(":name", $vendor->get_name());
        $query->bindValue(":shortname", $vendor->get_shortname());
        $query->bindValue(":region", $vendor->get_region());
        $query->bindValue(":id", $vendor->get_id());

        if (!$query->execute()){
            throw new PDOException("error editing vendor");
        }
    }

    public static function remove_by_id($id) {
        $query = Database::prepare("DELETE FROM vendors WHERE vendor_id = :id");
        $query->bindValue(":id", $id);

        if (!$query->execute()){
            throw new PDOException("error deleting a vendor");
        }
    }
}