<?php
include("connection.php");

//it contains functions that are used to execute mysqli standard functions 
//we can change it from here and in case of change to mysql or something else
//we only need to change here and all the functions in every file will work accordingly

function make_query($conn,$query){
	$result = mysqli_query($conn,$query);
	return $result;
}

function num_of_rows($retval){
	$result = mysqli_num_rows($retval);
	return $result;
}

function fetch_data($retval){
	$result = mysqli_fetch_assoc($retval);
	return $result;
}

function error(){
	$result = mysqli_error($conn);
	return $result;
}

function escape_string($conn,$query){
	$result = mysqli_real_escape_string($conn,$query);
	return $result;
}

?>