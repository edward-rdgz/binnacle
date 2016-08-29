<?php
function server() {
	return "localhost";
}
function user() {
	return "root";
}
function password(){
	return "";
}
function database() {
	return "bitacora";
}
function conectionDB() {
	$conection = mysql_connect(server(), user(), password()) or die (mysql_error());
	mysql_select_db(database()) or die (mysql_error());
	mysql_close() or die (mysql_error());
	return $conection;
}
?>