<?php
session_start();
require_once("settings.php");

$conn = mysqli_connect($host,$username,$password,$database);

if (!$conn){
    die("Database connect failed".mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $input_job_reference = trim($_POST['number']);
    $input_first_name = trim($_POST['first-name']);
    $input_last_name = trim($_POST['last-name']);
    $input_dob = trim($_POST['dob']);

    $input_gender = trim($_POST['gender']);
    
    $input_address = trim($_POST['address']);
    $input_suburb = trim($_POST['suburb']);
    $input_state = trim($_POST['state']);
    $input_postcode = trim($_POST['postcode']);
    $input_email = trim($_POST['email']);
    $input_phone = trim($_POST['phone']);

    $input_technical_skills = '';
    if (isset($_POST['technical_skills']) && is_array($_POST['technical_skills'])) {
        $input_technical_skills = implode(", ", array_map('trim', $_POST['technical_skills']));
    }


    
    $input_other_skills = trim($_POST['other_skills']);


    $insert = $conn->prepare("INSERT INTO eoi (
    Job_Reference_number, First_name, Last_name, dob, gender, Street_address,
    Suburb, State, Postcode, Email_address, Phone_number, technical_skills, other_skills)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $insert -> bind_param("sssssssssssss", 
    $input_job_reference, $input_first_name, $input_last_name,
    $input_dob, $input_gender, $input_address, $input_suburb, $input_state,
    $input_postcode, $input_email, $input_phone, $input_technical_skills, $input_other_skills);
    


    if ($insert->execute()){
        echo "Form submitted";
     } else {
        echo "Error: ";
     }
    

}
?>