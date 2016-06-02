<?php
/**
 * Created by PhpStorm.
 * User: kristjan
 * Date: 29/05/16
 * Time: 23:03
 */


function connect_db(){
    global $connection;
    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("can't connect with engine- ".mysqli_error($connection));
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("could not set utf-8 - ".mysqli_error($connection));
}

function queryArray($query){
    global $connection;

    $result = mysqli_query($connection, $query) or die ("$query - ".mysqli_error($connection));

    $answer = Array();
    while ( $row = mysqli_fetch_array($result)) {
        $answer[] = $row;    
    }
    return $answer;
}

function queryRow($query){
    global $connection;
    
    $result = mysqli_query($connection, $query) or die ("$query - ".mysqli_error($connection));
    $row = mysqli_fetch_row($result);
    return $row;
}

function insertRow($query){
    global $connection;
    mysqli_query($connection, $query) or die ("$query - ".mysqli_error($connection));
    return mysqli_insert_id($connection);
}

?>