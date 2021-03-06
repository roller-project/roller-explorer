<br>
<div class="row">
	<div class="col-xs-12 col-lg-6" style="margin-bottom: 30px;">
		<div class="border" style="padding: 30px;">
			Block Number : <span data-block-number></span><br> 
			Block Time : <span data-block-time></span><br>
			Hashrate : <span data-hashrate></span><br>
			Network Difficulty : <br>
			
		</div>
	</div>
	<div class="col-xs-12 col-lg-6" style="margin-bottom: 30px;">
		<div class="btn-primary" style="padding: 30px;">
			Fork : 1,200,000<br>
			Account : 3,000,000<br>
			Prices : 0.0126$<br>
			Exchange : https://smarts.exchange
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-12 col-lg-6" style="margin-bottom: 30px;">
		<h4>Blocks
			<div class="float-right">
				<a href="" class="btn btn-info btn-sm">View All</a>
			</div>
		</h4>
		<hr>
		
		<div class="fixheight">

			<ul class="blocks">
				<?php for($i=0; $i<10; $i++){ ?>
				 	<li  style="font-size: 14px; position: relative; display: block; margin-bottom: 20px; overflow: hidden; min-height: 60px;max-height: 60px; ">
						<div class="w-20 bg-secondary text-white" style="float: left; min-width: 20%; max-width: 100%; padding: 10px;">
							Block <br><span data-blocks></span>
						</div>
						<div class="w-80" style="margin-left: 20%; padding-left: 30px;">
							Miner : <span data-miner></span><br>
							<span data-tx></span> txs : <br>
							Block Reward
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
			
	</div>

	<div class="col-xs-12 col-lg-6" style="margin-bottom: 30px;">
		<h4>Transactions
			<div class="float-right">
				<a href="" class="btn btn-info btn-sm">View All</a>
			</div>
		</h4>
		<hr>
		<div class="fixheight">
		<ul class="transactions">
			<?php for($i=0; $i<10; $i++){ ?>
			 <li style="font-size: 14px; position: relative;margin-bottom: 20px; min-height: 60px;max-height: 60px; overflow: hidden; display: block;">
					<div class="w-20 bg-primary text-white" style="float: left; min-width: 130px; max-width: 130px; padding: 10px; overflow: hidden;">
						Amount <br>
						<div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" data-amount></div>
					</div>
					<div class="w-80 data" style="margin-left: 20%; padding-left: 30px;">
					Tx: <span data-tx> </span> <br>
					Form: <span data-form></span><br>
					To: <span data-to></span>
					</div>
			</li>
			<?php } ?>
		</ul>
			
		</div>
	</div>

</div>

<style type="text/css">
	.fixheight{
		min-height:450px; 
	}
</style>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var loaddata = function(){
			$.getJSON( "/blockchain/dashboard").done(function(data){
				

				$("[data-block-number]").text(data.blocknumer);
				$("[data-block-time]").text(data.blocktime+" (s)");
				$("[data-hashrate]").text(data.hashrate);
				data.transactions.reverse().forEach(function(item, index){
					
					var items = $(".transactions li").eq( index );
					items.find('[data-tx]').html('<a href="/blockchain/tx/'+item.hash+'">'+item.hash+'</a>');
					items.find('[data-form]').html('<a href="/blockchain/wallet/'+item.from+'">'+item.from+'</a>');
					items.find('[data-to]').html('<a href="/blockchain/wallet/'+item.to+'">'+item.to+'</a>');
					items.find('[data-amount]').text(item.value);
				});

				

				data.blocks.reverse().forEach(function(item, index){
					
					var items = $(".blocks li").eq( index );
					items.find('[data-blocks]').html('<a style="color:#FFF;" href="/blockchain/block/'+item.number+'">'+item.number+'</a>');
					items.find('[data-miner]').html('<a href="/blockchain/wallet/'+item.miner+'">'+item.miner+'</a>');
					items.find('[data-tx]').text(item.transactions);
					items.find('[data-amount]').text(item.value);
				});

			});
		}
		loaddata();
		
		setInterval(loaddata,1000);
		
		
	});
</script>