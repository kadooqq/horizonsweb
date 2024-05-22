<?php
require_once('./core/psql_db.php');
require_once('./entities/mech-prop-tol-info.php');

class MechPropTolTable {
    public static string $table_name = "MECH_PROP_TOL_info";

    private static function _from_row(mixed $row) : MechPropTol {
        $mech_prop_tol = new MechPropTol();
        $mech_prop_tol->set_id($row['id'] ?? 0);
        $mech_prop_tol->set_min($row['min'] ?? 0);
        $mech_prop_tol->set_mech_prop_id($row['MECH_PROP_info_id'] ?? 0);
        $mech_prop_tol->set_steel_grade_id($row['STEEL_GRADE_info_id'] ?? 0);

        return $mech_prop_tol;
    }

    public static function select_all($limit = null): array
    {
        $query =  Database::prepare("select * from ".static::$table_name.";");
        $query->execute();
        $result = $query->fetchAll();
        $array_mech_prop_tol = array();

        foreach ($result as $row) {
            $array_mech_prop_tol[] = self::_from_row($row);
        }

        return $array_mech_prop_tol;
    }

    public static function select_by_id(int $mech_prop_id, int $steel_grade_id) : MechPropTol | null {
        $query = Database::prepare("SELECT * FROM ".self::$table_name." WHERE mech_prop_info_id = :mech_prop_id and steel_grade_info_id = :steel_grade_id;");
        $query->bindValue(":mech_prop_id", $mech_prop_id);
        $query->bindValue(":steel_grade_id", $steel_grade_id);
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
