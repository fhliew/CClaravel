@extends('cctopborder')
<?php   
    /*include_once('CCa.php');
    if (session_status() === PHP_SESSION_NONE) session_start();
	if (!empty($_GET['page'])){	
		include_once "index.php";
	}*/
?> 
@section('content')
    <?php
        include "../app/Http/Controllers/Accountlistmanager.php";
    ?>     
@endsection
