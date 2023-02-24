<?php
	// suformuojame puslapių kelio (breadcrumb) elementų masyvą
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Pradžia'), array('title' => 'Sutartys'));
	
	// puslapių kelio šabloną
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	
</div>

<table class="table">
	<tr>
		<th>Nr.</th>
		<th>Data</th>
		<th>Darbuotojas</th>
		<th>Nuomininkas</th>
		<th>Būsena</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['nr']}</td>"
					. "<td>{$val['sutarties_data']}</td>"
					. "<td>{$val['darbuotojo_vardas']} {$val['darbuotojo_pavarde']}</td>"
					. "<td>{$val['kliento_vardas']} {$val['kliento_pavarde']}</td>"
					. "<td>{$val['busena']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
                        . "<a href='index.php?module={$module}&action=edit&id={$val['nr']}'>peržiūrėti</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/common/paging.tpl.php';
?>