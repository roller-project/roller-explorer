<br>
<div class="row">
	<div class="col">
		<a href="/blockchain/block/<?php echo $data["number"] - 1;?>"><h2 class="btn btn-lg btn-outline-info btn-block text-left"><<< <?php echo $data["number"] - 1;?></h2></a>
	</div>
	<div class="col"><h1 class="text-center"><?php echo $data["number"];?></h1></div>
	<div class="col">
		<a href="/blockchain/block/<?php echo $data["number"] + 1;?>"><h2 class="btn btn-lg btn-outline-info btn-block text-right"><?php echo $data["number"] +1;?> >>> </h2></a>
	</div>

</div>
<br>
<table class="table">
	<tbody>
		<?php foreach ($data as $key => $value) { ?>
			
			<tr>
				<td><?php echo $key;?></td>
				<td><?php echo $value;?></td>
			</tr>
		<?php } ?>

	</tbody>
</table>

<?php if($transactions){ ?>
<h3>Transactions</h3>
<table class="table">
	<thead>
		<th>Form</th>
		<th>To</th>
		<th>Amount</th>
	</thead>
	<tbody>
		<?php foreach ($transactions as $key => $value) { ?>
			
		<tr>
			<td><?php echo $value->from;?></td>
			<td><?php echo $value->to;?></td>
			<td><?php echo $controller->decode_hex($value->value)/$controller->bigum;?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
