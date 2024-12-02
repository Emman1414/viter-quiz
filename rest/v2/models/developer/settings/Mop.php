<?php
class Mop
{
    public $mop_aid;
    public $mop_title;
    public $mop_is_active;
    public $mop_datetime;
    public $mop_created;

    public $connection;
    public $lastInsertedId;

    public $tblmop;

    public $mop_start;
    public $mop_total;
    public $mop_search;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblmop = "ramen_settings_mop";
    }

    // create
    public function create()
    {
        try {
            $sql = "insert into {$this->tblmop} ";
            $sql .= "( mop_title, ";
            $sql .= "mop_is_active, ";
            $sql .= "mop_datetime, ";
            $sql .= "mop_created ) values ( ";
            $sql .= ":mop_title, ";
            $sql .= ":mop_is_active, ";
            $sql .= ":mop_datetime, ";
            $sql .= ":mop_created ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_title" => $this->mop_title,
                "mop_is_active" => $this->mop_is_active,
                "mop_datetime" => $this->mop_datetime,
                "mop_created" => $this->mop_created,
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
            $sql = "select * from {$this->tblmop} ";
            $sql .= "order by mop_is_active desc, ";
            $sql .= "mop_title asc ";
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
            $sql = "select * from {$this->tblmop} ";
            $sql .= "order by mop_is_active desc, ";
            $sql .= "mop_title asc ";
            $sql .= "limit :start, ";
            $sql .= ":total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->mop_start - 1,
                "total" => $this->mop_total,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }


    public function search()
    {
        try {
            $sql = "select * from {$this->tblmop} ";
            $sql .= "where mop_title like :mop_title ";
            $sql .= "order by mop_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_title" => "%{$this->mop_search}%",
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
            $sql = "select * from {$this->tblmop} ";
            $sql .= "where mop_aid  = :mop_aid ";
            $sql .= "order by mop_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_aid" => $this->mop_aid,
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
            $sql = "update {$this->tblmop} set ";
            $sql .= "mop_title = :mop_title, ";
            $sql .= "mop_datetime = :mop_datetime ";
            $sql .= "where mop_aid = :mop_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_title" => $this->mop_title,
                "mop_datetime" => $this->mop_datetime,
                "mop_aid" => $this->mop_aid,
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
            $sql = "update {$this->tblmop} set ";
            $sql .= "mop_is_active = :mop_is_active, ";
            $sql .= "mop_datetime = :mop_datetime ";
            $sql .= "where mop_aid = :mop_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_is_active" => $this->mop_is_active,
                "mop_datetime" => $this->mop_datetime,
                "mop_aid" => $this->mop_aid,
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
            $sql = "delete from {$this->tblmop} ";
            $sql .= "where mop_aid = :mop_aid  ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_aid" => $this->mop_aid,
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
            $sql = "select mop_title from {$this->tblmop} ";
            $sql .= "where mop_title = :mop_title ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_title" => "{$this->mop_title}",
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
    //         $sql = "select product_mop_id from {$this->tblmop} ";
    //         $sql .= "where product_mop_id = :product_mop_id ";
    //         $query = $this->connection->prepare($sql);
    //         $query->execute([
    //             "product_mop_id" => $this->mop_aid,
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
            $sql .= "from {$this->tblmop} ";
            $sql .= "where mop_is_active = :mop_is_active  ";
            $sql .= "order by mop_is_active desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_is_active" => $this->mop_is_active,
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
            $sql .= "from {$this->tblmop} ";
            $sql .= "where ";
            $sql .= "mop_is_active = :mop_is_active ";
            $sql .= "and mop_title like :mop_title ";
            $sql .= "order by mop_is_active desc, ";
            $sql .= "mop_title asc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "mop_title" => "%{$this->mop_search}%",
                "mop_is_active" => $this->mop_is_active,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }
}