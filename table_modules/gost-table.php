<?php
require_once('./core/psql_db.php');
require_once('./entities/gost-info.php');

class GostTable {
    public static string $table_name = "GOST_info";

    private static function _from_row(mixed $row) : Gost {
        $gost = new Gost();
        $gost->set_id($row['id'] ?? 0);
        $gost->set_name($row['name'] ?? 0);

        return $gost;
    }

    public static function select_all($limit = null): array
    {
        $query =  Database::prepare("select * from ".static::$table_name.";");
        $query->execute();
        $result = $query->fetchAll();
        $array_gosts = array();

        foreach ($result as $row) {
            $array_gosts[] = self::_from_row($row);
        }

        return $array_gosts;
    }

    public static function select_by_id(int $id) : Gost | null {
        $query = Database::prepare("SELECT * FROM ".self::$table_name." WHERE id = :id;");
        $query->bindValue(":id", $id);
        $query->execute();

        $result = $query->fetchAll();

        if (!count($result))
            return null;
        return self::_from_row($result[0]);
    }

    // public static function create(Vendor $vendor) {
    //     $query = Database::prepare("INSERT INTO vendors (vendor_name, vendor_shortname, vendor_region) VALUES (:name, :shortname, :region);");

    //     $query->bindValue(":name", $vendor->get_name());
    //     $query->bindValue(":shortname", $vendor->get_shortname());
    //     $query->bindValue(":region", $vendor->get_region());

    //     if(!$query->execute()){
    //         throw new PDOException("error creating a vendor");
    //     }
    // }

    // public static function update(Vendor $vendor) {
    //     $query = Database::prepare("UPDATE vendors SET vendor_name = :name, vendor_shortname = :shortname, vendor_region = :region WHERE vendor_id = :id;");

    //     $query->bindValue(":name", $vendor->get_name());
    //     $query->bindValue(":shortname", $vendor->get_shortname());
    //     $query->bindValue(":region", $vendor->get_region());
    //     $query->bindValue(":id", $vendor->get_id());

    //     if (!$query->execute()){
    //         throw new PDOException("error editing vendor");
    //     }
    // }

    // public static function remove_by_id($id) {
    //     $query = Database::prepare("DELETE FROM vendors WHERE vendor_id = :id");
    //     $query->bindValue(":id", $id);

    //     if (!$query->execute()){
    //         throw new PDOException("error deleting a vendor");
    //     }
    // }
}
