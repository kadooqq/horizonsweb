<?php
require_once('./core/psql_db.php');
require_once('./entities/wall-thickness-info.php');

class WallThicknessTable {
    public static string $table_name = "WALL_THICKNESS_info";

    private static function _from_row(mixed $row) : WallThickness {
        $wall_thickness = new WallThickness();
        $wall_thickness->set_id($row['id'] ?? 0);
        $wall_thickness->set_value($row['value'] ?? 0);

        return $wall_thickness;
    }

    public static function select_all($limit = null): array
    {
        $query =  Database::prepare("select * from ".static::$table_name.";");
        $query->execute();
        $result = $query->fetchAll();
        $array_wall_thickness = array();

        foreach ($result as $row) {
            $array_wall_thickness[] = self::_from_row($row);
        }

        return $array_wall_thickness;
    }

    public static function select_by_id(int $id) : WallThickness | null {
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
