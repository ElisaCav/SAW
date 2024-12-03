<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
	<?php
	include "common/common_head.php";
	?>
	
	<link rel="stylesheet" href="../style/search.css">
	<title>Risultati della ricerca</title>
</head>

<body>

	<?php
	require_once '../php/auth.php';
	include("common/navbar.php");

	ini_set('log_errors', 1);
	ini_set('error_log', '../logs/search.log');

	require_once "../db/mysql_credentials.php";
	require_once "../php/dbconnections.php";

	if (isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
		$searchTerm = $_POST['searchInput'];
		$regex = '%' . $searchTerm . '%';
		$query = 'SELECT  `name`, `owner`, `address`, `phone`, `capacity`, `type`, `price`  
		FROM `location` 
		WHERE `name` LIKE ?
		OR `owner` LIKE ?
		OR `address` LIKE ?
		OR `description` LIKE ?;';

	$data = fetch_multiple_results($con, $query, 'ssss', [$regex, $regex, $regex, $regex]);

	echo '<div class="table-responsive">';
	echo '<table id="searchResults">
		<thead>
			<tr>
			<th>Nome</th>
			<th>Proprietario</th>
			<th>Indirizzo</th>
			<th>Telefono</th>
			<th>Capacità</th>
			<th>Tipo</th>
			<th>Prezzo orario</th>
			</tr>
		</thead>
		<tbody>';
	foreach ($data as $location) {
		echo '<tr>';
		echo '<td>' . $location['name'] . '</td>';
		echo '<td>' . $location['owner'] . '</td>';
		echo '<td>' . $location['address'] . '</td>';
		echo '<td>' . $location['phone'] . '</td>';
		echo '<td>' . $location['capacity'] . '</td>';
		echo '<td>' . $location['type'] . '</td>';
		echo '<td>' . $location['price'] . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo '</div>';

	include "common/footer.php";
}
