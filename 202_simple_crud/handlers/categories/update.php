<?php

// include_once '../../core/connect.php';

use Core\DB;

include_once '../../core/validation.php';
include_once '../../core/session.php';
include_once '../../core/Database.php';


if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // Inputs
    $id             = $_POST['id'];
    $name           = validString($_POST['name']) ?? "";
    $description    = validString($_POST['description']) ?? "";

    // Errors Arr
    $errors = [];


    // Validate Category Name
    if(empty($name)){
        $errors[] = "Category Name Is Required!";
    } elseif (minVal($name, 3) || maxVal($name, 50)) {
        $errors[] = "Category Name Must Be Between 3 and 50 Characters";
    }

    // Validate Category Description
    if(empty($description)){
        $errors[] = "Category Description Is Required!";
    } elseif (minVal($description, 3)) {
        $errors[] = "Category Description Can't Be Less Than 3 Characters";
    }

    if($errors){
        setSession('errors', $errors);
        header("Location:../../categories/edit.php?id=".$id);
        exit();
    } else {

        $data = ['name'=>$name, 'description'=>$description];
        $db = new DB();
        $db->table('categories')->where('id', '=', $id)->update($data);
        // $sql = "UPDATE `categories` SET `name`='$name', `description`='$description' WHERE `id`='$id'";
        // $result = mysqli_query($conn, $sql);
        if($db->save()){
            setSession('success', "Category Update Successfully");
            header("Location:../../categories/index.php");
            exit();
        }
    }
}

header("Location:../../categories/index.php");