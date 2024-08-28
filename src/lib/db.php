<?php


class DB
{
    private $db;
    public function __construct()
    {
        $this->db = new SQLite3(__DIR__.'/../data/stats.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        
        $this->createTables();
    }

    private function createTables(){
        $this->db->query('CREATE TABLE IF NOT EXISTS "totp" (
            "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "titel" VARCHAR,
            "key" VARCHAR
        )');
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM totp WHERE "id" == ?');
        $query->bindValue(1,$id);
        $execution = $query->execute();

        $data = [];
        while($row = $execution->fetchArray(SQLITE3_ASSOC)){
            $data = $row;
        }
        $execution->finalize();
        return $data;
    }

    public function delete($id) {
        $query = $this->db->prepare('DELETE FROM totp WHERE "id" == ?');
        $query->bindValue(1,$id);
        $execution = $query->execute();
    }

    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM totp ORDER BY "titel"');
        $execution = $query->execute();

        $data = [];
        while($row = $execution->fetchArray(SQLITE3_ASSOC)){
            array_push($data,$row);
        }
        $execution->finalize();
        return $data;
    }

    public function add($titel,$key){
        $query = $this->db->prepare('INSERT INTO "totp" ("titel","key") VALUES(?,?)');
        $query->bindValue(1,$titel);
        $query->bindValue(2,$key);
        $query->execute();
    }
}