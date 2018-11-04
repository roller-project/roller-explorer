<h4>Roller Platform Tokens</h4>
<p>We Support token format ERC20, ERC23, ERC721</p>

<table class="table">
	<thead>
		
		<th>Name</th>
		<th>Wallet Master</th>
		<th>Total</th>
		<th>Format</th>
		
		<th>Authour</th>
		<th>Create</th>
		<th></th>
	</thead>
	<tbody>
		<?php 
		$tokens = [
			"ROLX" => ["wallet" => "0x4c77df6093ad9c2a53ecf6b111723605ae09de0e", "total" => 5000000, "format" => "ERC20","company" => "Roller Platform"],
			"SLN" => ["wallet" => "0x4c77df6093ad9c2a53ecf6b111723605ae09de0e", "total" => 5000000, "format" => "ERC20","company" => "Roller Platform"],
			"XTN" => ["wallet" => "0x4c77df6093ad9c2a53ecf6b111723605ae09de0e", "total" => 5000000, "format" => "ERC20","company" => "Roller Platform"],
			"VTG" => ["wallet" => "0x4c77df6093ad9c2a53ecf6b111723605ae09de0e", "total" => 5000000, "format" => "ERC20","company" => "Roller Platform"]
		];
		foreach ($tokens as $key => $value) { ?>
			
		<tr>
			<td><?php echo $key;?></td>
			<td><?php echo $value["wallet"];?></td>
			<td><?php echo $value["total"];?></td>
			<td><?php echo $value["format"];?></td>
			<td><?php echo $value["company"];?></td>
			<td><?php echo date("r");?></td>
			<td class="text-right">
				<a href="#" class="btn btn-sm btn-outline-info">Exchange</a>
				<a href="#" class="btn btn-sm btn-outline-info">Buy Presale</a>
				<a href="#" class="btn btn-sm btn-outline-info">Clone</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<hr>
<p><b>Note</b> : Your need 10.000 ROL in wallet Auto create token. Click here auto create token</p>