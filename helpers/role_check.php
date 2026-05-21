<?php

function role($role){

if($_SESSION['role'] != $role){

die('Akses ditolak');

}

}

?>