<?php
class Promo
{
    public $promo_aid;
    public $promo_title;
    public $promo_is_active;
    public $promo_datetime;
    public $promo_created;

    public $connection;
    public $lastInsertedId;

    public $tblpromo;

    public $promo_start;
    public $promo_total;
    public $promo_search;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblpromo = "ramen_settings_promo";
    }

    // create
    public function create()
    {
        try {
            $sql = "insert into {$this->tblpromo} ";
            $sql .= "( promo_title, ";
            $sql .= "promo_is_active, ";
            $sql .= "promo_datetime, ";
            $sql .= "promo_created ) values ( ";
            $sql .= ":promo_title, ";
            $sql .= ":promo_is_active, ";
            $sql .= ":promo_datetime, ";
            $sql .= ":promo_created ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_title" => $this->promo_title,
                "promo_is_active" => $this->promo_is_active,
                "promo_datetime" => $this->promo_datetime,
                "promo_created" => $this->promo_created,
            ]);
            $this->lastInsertedId = $this->connection->lastInsertId();
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // read all
    public function readAll()
    {
        try {
            $sql = "select * from {$this->tblpromo} ";
            $sql .= "order by promo_is_active desc, ";
            $sql .= "promo_title asc ";
            $query = $this->connection->query($sql);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // read limit
    public function readLimit()
    {
        try {
            $sql = "select * from {$this->tblpromo} ";
            $sql .= "order by promo_is_active desc, ";
            $sql .= "promo_title asc ";
            $sql .= "limit :start, ";
            $sql .= ":total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->promo_start - 1,
                "total" => $this->promo_total,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }


    public function search()
    {
        try {
            $sql = "select * from {$this->tblpromo} ";
            $sql .= "where promo_title like :promo_title ";
            $sql .= "order by promo_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_title" => "%{$this->promo_search}%",
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }


    // read by id
    public function readById()
    {
        try {
            $sql = "select * from {$this->tblpromo} ";
            $sql .= "where promo_aid  = :promo_aid ";
            $sql .= "order by promo_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_aid" => $this->promo_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // update
    public function update()
    {
        try {
            $sql = "update {$this->tblpromo} set ";
            $sql .= "promo_title = :promo_title, ";
            $sql .= "promo_datetime = :promo_datetime ";
            $sql .= "where promo_aid = :promo_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_title" => $this->promo_title,
                "promo_datetime" => $this->promo_datetime,
                "promo_aid" => $this->promo_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // active
    public function active()
    {
        try {
            $sql = "update {$this->tblpromo} set ";
            $sql .= "promo_is_active = :promo_is_active, ";
            $sql .= "promo_datetime = :promo_datetime ";
            $sql .= "where promo_aid = :promo_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_is_active" => $this->promo_is_active,
                "promo_datetime" => $this->promo_datetime,
                "promo_aid" => $this->promo_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // delete
    public function delete()
    {
        try {
            $sql = "delete from {$this->tblpromo} ";
            $sql .= "where promo_aid = :promo_aid  ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_aid" => $this->promo_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // name
    public function checkName()
    {
        try {
            $sql = "select promo_title from {$this->tblpromo} ";
            $sql .= "where promo_title = :promo_title ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_title" => "{$this->promo_title}",
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // // name
    // public function checkAssociation()
    // {
    //     try {
    //         $sql = "select product_promo_id from {$this->tblpromo} ";
    //         $sql .= "where product_promo_id = :product_promo_id ";
    //         $query = $this->connection->prepare($sql);
    //         $query->execute([
    //             "product_promo_id" => $this->promo_aid,
    //         ]);
    //     } catch (PDOException $ex) {
    //         $query = false;
    //     }
    //     return $query;
    // }


    public function filterByStatus()
    {
        try {
            $sql = "select * ";
            $sql .= "from {$this->tblpromo} ";
            $sql .= "where promo_is_active = :promo_is_active  ";
            $sql .= "order by promo_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_is_active" => $this->promo_is_active,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function filterByStatusAndSearch()
    {
        try {
            $sql = "select * ";
            $sql .= "from {$this->tblpromo} ";
            $sql .= "where ";
            $sql .= "promo_is_active = :promo_is_active ";
            $sql .= "and promo_title like :promo_title ";
            $sql .= "order by promo_is_active desc, ";
            $sql .= "promo_title asc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "promo_title" => "%{$this->promo_search}%",
                "promo_is_active" => $this->promo_is_active,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }
}