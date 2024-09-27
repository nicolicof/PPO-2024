<?php
session_start();
require '../php/checker.php';
runChecks();
checkLogin();
require '../php/db.php';
$sql = "SELECT e.nome_local, d.id, d.created_at, d.classificacao, d.corrigida
        FROM denuncia d
        JOIN enderecos e ON d.address_id = e.id
        ORDER BY d.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$denuncias = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../public/css/style.css" />
		<title>SDIP</title>
		<style>
			table {
				width: 924px;
				table-layout: auto;
				border-color: transparent;
				outline-color: transparent;
				column-rule-color: red;
				border-collapse: collapse;
			}
			th, td {
				padding: 16px 16px;
				width: 100%;
				text-align: left;
			}
			thead th{
				background-color: #E0E0E0;
				border-bottom: 1px solid #CCCCCC;
				border-right: 1px solid #CCCCCC;
				border-left: 1px solid #CCCCCC;
			}
			thead tr th{
				user-select: none;
			}

			thead th:first-child{
				border-left: none;
			}
			thead th:last-child{
				border-right: none;
			}
			
			tbody tr td{
				border: 1px solid #CCCCCC;
				user-select: none;
			}

			tbody tr :first-child{
				border-left: none;
			}
			tbody tr :last-child{
				border-right: none
			}
			tbody tr:hover {
				background-color: #D9D9D9;
			}
			tbody tr:active{
				background-color: #CCCCCC;
			}
			.search-container_ {
				display: flex;
				flex-direction: row;
				gap: 18px;
				margin-bottom: 18px;
			}
			.search-container_ input:first-child {
				width: 100%;
			}
		</style>
	</head>
	<body>
		<header>
			<div class="header">
				<div class="logo">
					<span>SDIP</span>
					<span>- Sistema de Denúncias de Infraestruturas Públicas</span>
				</div>
				<a class="perfil_btn" href="profile.php"><img src="../public/img/perfil.svg" alt="Perfil" />Perfil</a>
			</div>
		</header>
		<main>
			<div>
				<div class="search-container_">
					<input type="text" id="search_l" placeholder="Buscar por local" onkeyup="filterTable()" />
					<input type="date" id="dateFilter" onchange="filterByDate()" />
				</div>
				<table id="denunciaTable">
					<thead>
						<tr>
							<th>Local</th>
							<th>Estado</th>
							<th>Expedição</th>
							<th>Classificação</th>
							<th>Corrigida</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($denuncias) {
							foreach ($denuncias as $row) {
								$corrigidaClass = $row['corrigida'] ? 'corrigida' : '';
								echo "<tr class='$corrigidaClass' onclick=\"window.location='srv_report.php?denuncia_id=" . $row['id'] . "'\">";
								echo "<td>" . htmlspecialchars($row['nome_local']) . "</td>";
								echo "<td>" . ($row['corrigida'] ? 'Corrigida' : 'Nova') . "</td>";
								echo "<td>" . date("d/m/Y", strtotime($row['created_at'])) . "</td>";
								echo "<td>" . htmlspecialchars($row['classificacao']) . "</td>";
								echo "<td>" . ($row['corrigida'] ? 'Sim' : 'Não') . "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='5'>Nenhuma denúncia encontrada.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</main>
		<script>
			function filterTable() {
				const input = document.getElementById('search_l');
				const filter = input.value.toLowerCase();
				const table = document.getElementById('denunciaTable');
				const tr = table.getElementsByTagName('tr');
				for (let i = 1; i < tr.length; i++) {
					const td = tr[i].getElementsByTagName('td')[0];
					if (td) {
						const txtValue = td.textContent || td.innerText;
						tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
					}
				}
			}
			function filterByDate() {
				const inputDate = document.getElementById('dateFilter').value;
				const table = document.getElementById('denunciaTable');
				const tr = table.getElementsByTagName('tr');
				for (let i = 1; i < tr.length; i++) {
					const td = tr[i].getElementsByTagName('td')[2];
					if (td) {
						const tdDate = new Date(td.textContent);
						const selectedDate = new Date(inputDate);
						tr[i].style.display = (tdDate.toDateString() === selectedDate.toDateString()) ? '' : 'none';
					}
				}
			}
		</script>
	</body>
</html>
