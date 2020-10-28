<?php

namespace Renan\Model;

use Renan\Banco\Sql;
use Renan\Model;

class Product extends Model {
    public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
    }

    public function get($idproduct) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct" => $idproduct
        ));

        $this->setData($results[0]);
    }

    public function update() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin,  :despassword, :desemail, :nrphone, :inadmin)", array(
            ":iduser" => $this->getiduser(),
            ":desperson" => $this->getdesperson(),
            ":deslogin" => $this->getdeslogin(),
            ":despassword" => $this->getdespassword(),
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));

        $this->setData($results[0]);
    }

    public function save() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
            ":idproduct" => $this->getidproduct(),
            ":desproduct" => $this->getdesproduct(),
            ":vlprice" => $this->getvlprice(),
            ":vlwidth" => $this->getvlwidth(),
            ":vlheight" => $this->vlheight(),
            ":vllength" => $this->getvllength(),
            ":vlweight" => $this->getvlweight(),
            ":desurl" => $this->getdesurl()
        ));

        $this->setData($results[0]);
    }

    public function delete(){
        $sql = new Sql();
        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct" => $this->getidproduct()
        ));
    }
}