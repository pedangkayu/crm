<?php
namespace App\Core;

class DatabaseMigration 
{ 

    //get the sql name from config file
    private $fileName = '../../public/files/Load.sql';

    //connect to server
    public function connectDatabase($data = [])
    {

        $conn = new \mysqli(
            $data['hostname'], 
            $data['username'], 
            $data['password'],
            $data['database'] 
        );   

        //if error occurs return false
        if ($conn->connect_error) {
            return false;
        } else {
            return $conn;
        }

        // close the connection
        $conn->close(); 

    }

    //create database with post data
    public function createDatabase($data = [])
    { 

        //calling connectionDatabase() to check the connection
        $conn = $this->connectDatabase($data);

        if ($conn === false) {
            return false;
        } else {

            //create/check database name 
            $createDatabaseName = $conn->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

            if (!$createDatabaseName) {
                return false;
            } else {
                return true;
            } 

        }

    }

    // create the tables and fill them with the default data
    public function createTables($data = [])
    {

        //calling connectionDatabase() to check the connection
        $conn = $this->connectDatabase($data);

        if ($conn === false) {
            return false;
        } else {

            // open the default SQL file
            $query = $this->openSqlFileWithData();

            //create multiple tables with multi query 
            $conn->query('SET foreign_key_checks = 0');
            $createTables = $conn->multi_query($query);
            $conn->query('SET foreign_key_checks = 1'); 

            if (!$createTables) {
                return false;
            } else {
                return true;
            } 
 
        }   

    }

    // open the default SQL file
    public function openSqlFileWithData()
    {
        //check file exits
        if (!file_exists($this->fileName)) {
            return false;
        } else {
            //get data from the file
            return file_get_contents($this->fileName);
        }
    }


}


 