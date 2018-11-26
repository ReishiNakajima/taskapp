<?php

class dao
{
    protected $db;
    // DBに接続する
    public function __construct()
    {
        try {
            // $db = new PDO('mysql:host=localhost;dbname=mydb','task','pass');
            $this->db = new PDO('mysql:host=us-cdbr-iron-east-01.cleardb.net;dbname=heroku_ddcb2b282511a28;charset=utf8', 'b7d179cccfc560', '184764d8');
        } catch (PODException $e) {
            print $e->getMessage();
            die();
        }
    }
}
