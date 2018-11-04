<br>
<div class="row">
	

	<div class="col">
		<div class="card">
			<div class="card-body">
				Wallet : <?php echo $wallet;?><br>
				Balance : <?php echo $balance/ $controller->bigum;?>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card">
			<div class="card-body">
				<button type="button" class="btn btn-success">Create Tokens</button>
				<button type="button" class="btn btn-danger">Send Transactions</button>
				<button type="button" class="btn btn-warning">Send Exchange</button>
			</div>
		</div>
	</div>

</div>
<br>
<h3>Token Balance</h3>
<button type="button" class="btn btn-outline-success">200 SLN</button>
<button type="button" class="btn btn-outline-success">200 ROLX</button>
<button type="button" class="btn btn-outline-success">200 RXT</button>

<br><br>
<h3>Transactions</h3>
<table class="table">
	<thead>
		<th>Block</th>
		<th>Form</th>
		<th>To</th>
		<th>Amount</th>
	</thead>
	<tbody>
		<?php foreach ($transactions as $key => $value) { ?>
			
		<tr>
			<td><a href="/blockchain/block/<?php echo $value->blockNumber;?>"><?php echo $value->blockNumber;?></a></td>
			<td><?php echo ($wallet != $value->from ? '<a href="/blockchain/wallet/'.$value->from.'">'.$value->from.'</a>' : $value->from);?></td>
			<td><?php echo ($wallet != $value->to ? '<a href="/blockchain/wallet/'.$value->to.'">'.$value->to.'</a>' : $value->to);?></a></td>
			<td><?php echo number_format($value->value,16,".",",");?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>