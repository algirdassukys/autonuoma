<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Sutartys</a></li>
	<li><?php if(!empty($id)) echo "Sutarties redagavimas"; else echo "Nauja sutartis"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php if($formErrors != null) { ?>
		<div class="errorBox">
			Neįvesti arba neteisingai įvesti šie laukai:
			<?php 
				echo $formErrors;
			?>
		</div>
	<?php } ?>
	<form action="" method="post">
		<fieldset>
			<legend>Sutarties informacija</legend>
			<p>
				<?php if(!isset($data['editing'])) { ?>
					<label class="field" for="nr">Numeris<?php echo in_array('nr', $required) ? '<span> *</span>' : ''; ?></label>
					<input type="text" id="nr" name="nr" class="textbox textbox-70" value="<?php echo isset($data['nr']) ? $data['nr'] : ''; ?>">
				<?php } else { ?>
						<label class="field" for="nr">Numeris</label>
						<span class="input-value"><?php echo $data['nr']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="nr" value="<?php echo $data['nr']; ?>" />
				<?php } ?>
			</p>
			<p>
				<label class="field" for="sutarties_data">Data<?php echo in_array('sutarties_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="sutarties_data" name="sutarties_data" class="textbox date textbox-70" value="<?php echo isset($data['sutarties_data']) ? $data['sutarties_data'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="fk_klientas">Klientas<?php echo in_array('fk_klientas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_klientas" name="fk_klientas">
					<option value="">---------------</option>
					<?php
						// išrenkame klientus
						$customers = $customersObj->getCustomersList();
						foreach($customers as $key => $val) {
							$selected = "";
							if(isset($data['fk_klientas']) && $data['fk_klientas'] == $val['asmens_kodas']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['asmens_kodas']}'>{$val['vardas']} {$val['pavarde']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="fk_darbuotojas">Darbuotojas<?php echo in_array('fk_darbuotojas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_darbuotojas" name="fk_darbuotojas">
					<option value="">---------------</option>
					<?php
						// išrenkame vartotojus
						$employees = $employeesObj->getEmplyeesList();
						foreach($employees as $key => $val) {
							$selected = "";
							if(isset($data['fk_darbuotojas']) && $data['fk_darbuotojas'] == $val['tabelio_nr']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['tabelio_nr']}'>{$val['vardas']} {$val['pavarde']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="nuomos_data_laikas">Nuomos data ir laikas<?php echo in_array('nuomos_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="nuomos_data_laikas" name="nuomos_data_laikas" class="textbox datetime textbox-150" value="<?php echo isset($data['nuomos_data_laikas']) ? $data['nuomos_data_laikas'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="planuojama_grazinimo_data_laikas">Planuojama grąžinti<?php echo in_array('planuojama_grazinimo_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="planuojama_grazinimo_data_laikas" name="planuojama_grazinimo_data_laikas" class="textbox datetime textbox-150" value="<?php echo isset($data['planuojama_grazinimo_data_laikas']) ? $data['planuojama_grazinimo_data_laikas'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="faktine_grazinimo_data_laikas">Grąžinta<?php echo in_array('faktine_grazinimo_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="faktine_grazinimo_data_laikas" name="faktine_grazinimo_data_laikas" class="textbox datetime textbox-150" value="<?php echo isset($data['faktine_grazinimo_data_laikas']) ? $data['faktine_grazinimo_data_laikas'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="busena">Būsena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="busena" name="busena">
					<option value="">---------------</option>
					<?php
						// išrenkame būsenas
						$states = $contractsObj->getContractStates();
						foreach($states as $key => $val) {
							$selected = "";
							if(isset($data['busena']) && $data['busena'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="kaina">Nuomos kaina<?php echo in_array('kaina', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="kaina" name="kaina" class="textbox textbox-70" value="<?php echo isset($data['kaina']) ? $data['kaina'] : ''; ?>"> <span class="units">&euro;</span>
			</p>
			<p>
				<label class="field" for="bendra_kaina">Bendra kaina su paslaugomis</label><span class="units"><?php echo isset($data['bendra_kaina']) ? $data['bendra_kaina'] . ' &euro;' : ''; ?></span>
				<input type="hidden" name="bendra_kaina" value="<?php echo isset($data['bendra_kaina']) ? $data['bendra_kaina'] : ''; ?>" />
			</p>
		</fieldset>

		<fieldset>
			<legend>Automobilio informacija</legend>
			<p>
				<label class="field" for="fk_automobilis">Automobilis<?php echo in_array('fk_automobilis', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_automobilis" name="fk_automobilis">
					<option value="">---------------</option>
					<?php
						// išrenkame automobilius
						$cars = $carsObj->getCarList();
						foreach($cars as $key => $val) {
							$selected = "";
							if(isset($data['fk_automobilis']) && $data['fk_automobilis'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['valstybinis_nr']} - {$val['marke']} {$val['modelis']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="fk_paemimo_vieta">Paėmimo vieta<?php echo in_array('fk_paemimo_vieta', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_paemimo_vieta" name="fk_paemimo_vieta">
					<option value="">---------------</option>
					<?php
						// išrenkame aikšteles
						$parkingLots = $contractsObj->getParkingLots();
						foreach($parkingLots as $key => $val) {
							$selected = "";
							if(isset($data['fk_paemimo_vieta']) && $data['fk_paemimo_vieta'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="pradine_rida">Rida paimant<?php echo in_array('pradine_rida', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="pradine_rida" name="pradine_rida" class="textbox textbox-70" value="<?php echo isset($data['pradine_rida']) ? $data['pradine_rida'] : ''; ?>"><span class="units">km.</span>
			</p>
			<p>
				<label class="field" for="degalu_kiekis_paimant">Degalų kiekis paimant<?php echo in_array('degalu_kiekis_paimant', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="degalu_kiekis_paimant" name="degalu_kiekis_paimant" class="textbox textbox-70" value="<?php echo isset($data['degalu_kiekis_paimant']) ? $data['degalu_kiekis_paimant'] : ''; ?>"><span class="units">l.</span>
			</p>
			<p>
				<label class="field" for="fk_grazinimo_vieta">Grąžinimo vieta<?php echo in_array('fk_grazinimo_vieta', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_grazinimo_vieta" name="fk_grazinimo_vieta">
					<option value="">---------------</option>
					<?php
						// išrenkame aikšteles
						$parkingLots = $contractsObj->getParkingLots();
						foreach($parkingLots as $key => $val) {
							$selected = "";
							if(isset($data['fk_grazinimo_vieta']) && $data['fk_grazinimo_vieta'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="galine_rida">Rida grąžinus<?php echo in_array('galine_rida', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="galine_rida" name="galine_rida" class="textbox textbox-70" value="<?php echo isset($data['galine_rida']) ? $data['galine_rida'] : ''; ?>"><span class="units">km.</span>
			</p>
			<p>
				<label class="field" for="dagalu_kiekis_grazinus">Degalų kiekis grąžinus<?php echo in_array('dagalu_kiekis_grazinus', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="dagalu_kiekis_grazinus" name="dagalu_kiekis_grazinus" class="textbox textbox-70" value="<?php echo isset($data['dagalu_kiekis_grazinus']) ? $data['dagalu_kiekis_grazinus'] : ''; ?>"><span class="units">l.</span>
			</p>
		</fieldset>

		<fieldset>
			<legend>Papildomos paslaugos</legend>
			<div class="childRowContainer">
				<div class="labelLeft wide<?php if(empty($data['uzsakytos_paslaugos']) || sizeof($data['uzsakytos_paslaugos']) == 0) echo ' hidden'; ?>">Paslauga</div>
				<div class="labelRight<?php if(empty($data['uzsakytos_paslaugos']) || sizeof($data['uzsakytos_paslaugos']) == 0) echo ' hidden'; ?>">Kiekis</div>
				<div class="float-clear"></div>
				<?php
					if(empty($data['uzsakytos_paslaugos']) || sizeof($data['uzsakytos_paslaugos']) == 0) {
				?>
					<div class="childRow hidden">
						<select class="elementSelector" name="paslaugos[]" disabled="disabled">
							<?php
								$tmp = $servicesObj->getServicesList();
								foreach($tmp as $key1 => $val1) {
									echo "<optgroup label='{$val1['pavadinimas']}'>";
									$tmp = $servicesObj->getServicePrices($val1['id']);
									foreach($tmp as $key2 => $val2) {
										$selected = "";
										if(isset($data['modelis']) && $data['modelis'] == $val2['id']) {
											$selected = " selected='selected'";
										}
										echo "<option{$selected} value='{$val2['fk_paslauga']}:{$val2['kaina']}:{$val2['galioja_nuo']}'>{$val1['pavadinimas']} {$val2['kaina']} EUR (nuo {$val2['galioja_nuo']})</option>";
									}
								}
							?>
						</select>
						<input type="text" name="kiekiai[]" class="textbox textbox-30" value="" disabled="disabled" />
						<a href="#" title="" class="removeChild">šalinti</a>
					</div>
					<div class="float-clear"></div>

				<?php
					} else {
						foreach($data['uzsakytos_paslaugos'] as $key => $val) {
				?>
						<div class="childRow">
							<select class="elementSelector" name="paslaugos[]">
								<?php
									$tmp = $servicesObj->getServicesList();
									foreach($tmp as $key1 => $val1) {
										echo "<optgroup label='{$val1['pavadinimas']}'>";
										$tmp = $servicesObj->getServicePrices($val1['id']);
										foreach($tmp as $key2 => $val2) {
											$selected = "";
											if($val['fk_kaina_galioja_nuo'] == $val2['galioja_nuo'] && $val['fk_paslauga'] == $val2['fk_paslauga']) {
												$selected = " selected='selected'";
											}
											echo "<option{$selected} value='{$val2['fk_paslauga']}:{$val2['kaina']}:{$val2['galioja_nuo']}'>{$val1['pavadinimas']} {$val2['kaina']} EUR (nuo {$val2['galioja_nuo']})</option>";
										}
									}
								?>
							</select>
							<input type="text" name="kiekiai[]" class="textbox textbox-30" value="<?php echo isset($val['kiekis']) ? $val['kiekis'] : ''; ?>" />
							<a href="#" title="" class="removeChild">šalinti</a>
						</div>
						<div class="float-clear"></div>
				<?php 
						}
					}
				?>
			</div>
			<p id="newItemButtonContainer">
				<a href="#" title="" class="addChild">Pridėti</a>
			</p>
		</fieldset>
		
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>

		<input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
	</form>
</div>