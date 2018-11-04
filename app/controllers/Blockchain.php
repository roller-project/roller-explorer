<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH."third_party/ethereum.php";
class Blockchain extends HomeController {
	private $connect = false;
	public $bigum = 10000000000;
	function __construct()
	{
		parent::__construct();
		$this->connect =  new EthereumRPC('http://127.0.0.1', 8545);
		$this->bigum = 1000000000000000000;
		$this->connect->bigum = $this->bigum;
	}

	
	public function index()
	{
		$this->view('welcome_message');
	}
	public function dashboard()
	{
		$blockLast = $this->connect->eth_blockNumber(true);
		$arvs = [];
		$blocks = [];
		for ($i=$blockLast - 200; $i < $blockLast; $i++) { 
			//$blockNum = $this->blockCount;
			$block = $this->connect->eth_getBlockByNumber('0x'.dechex($i));
			
			if(count($block->transactions) > 0){
				
				//$tx = $block->transactions[0];
				
				$trasic = $this->connect->eth_getTransactionByBlockHashAndIndex($block->hash, '0x0');
				$trasic->value = $this->connect->decode_hex($trasic->value)/$this->bigum;
				$trasic->blockNumber = $this->connect->decode_hex($trasic->blockNumber);
				$trasic->gas = $this->connect->decode_hex($trasic->gas)/$this->bigum;
				$trasic->gasPrice = $this->connect->decode_hex($trasic->gasPrice)/$this->bigum;
				$trasic->v = $this->connect->decode_hex($trasic->v);
				$arvs[] = $trasic;
				
			}

			$renBlock = [
				"difficulty" => $this->connect->decode_hex($block->difficulty),
				"extraData" => $block->extraData,
				"miner"	=> $block->miner,
				"number" => $this->connect->decode_hex($block->number),
				"timestamp" => $this->connect->decode_hex($block->timestamp),
				"totalDifficulty" => $this->connect->decode_hex($block->totalDifficulty),
				"transactions" => count($block->transactions),
				"reward" => $this->connect->decode_hex($block->sha3Uncles)*7/32
			];
			$blocks[] = $renBlock;
			
		}
		$blocktime = date("s",$blocks[count($blocks)-1]["timestamp"]) - date("s",$blocks[count($blocks)-2]["timestamp"]);
		$arv = [
			"blocknumer" => $blockLast,
			"peer" => $this->connect->net_peerCount(true),
			"hashrate" => $this->connect->eth_hashrate(),
			"gas"		=> $this->connect->eth_gasPrice(),
			"blocktime" => $blocktime,
			"transactions" => $arvs,
			"blocks" => $blocks
		];
		$this->exportJson($arv);
	}



	public function lockup(){
		$search = $this->input->get("input");
		$strlen = strlen($search);
		
		if(is_numeric($search)){
			$this->go("/blockchain/block/".$search);
		}
		if($strlen == 42){
			$this->go("/blockchain/wallet/".$search);
		}

		if($strlen == 66){
			$this->go("/blockchain/tx/".$search);
		}

		
	}

	public function tx($tx, $format=false){
		$datas = $this->connect->eth_getTransactionByHash($tx);
		
		$datas->blockNumber = $this->connect->decode_hex($datas->blockNumber);
		$datas->value = $this->connect->decode_hex($datas->value)/ $this->bigum;
		$datas->gasPrice = $this->connect->decode_hex($datas->gasPrice);
		$datas->gas = $this->connect->decode_hex($datas->gas);
		
		if($format == "json"){
			return $this->exportJson($datas);
		}
		$this->view("blocktx",["data" =>$datas, "controller" => $this->connect]);
	}


	public function wallet($wallet, $format=false){
		$datas = [];
		$this->view("wallet",["data" =>$datas, "controller" => $this->connect]);
	}

	public function addr($wallet){
		$this->wallet($wallet);
	}


	public function block($block, $format=false){

		$data = [
				"number" => 0,
				"hash" => "0x0",
				"miner" => "Roller platform",
				"extraData" => "Roller platform",
				"gasLimit" => "0",
				"mixHash" => "0x0",
				"parentHash" => "0x0",
				"receiptsRoot" => "0x0",
				"sha3Uncles" => "0x0",
				"size" => "0x0",
				"timestamp" => date('d-m-Y h:i:s'),
				"totalDifficulty" => "0x0",
				"stateRoot" => "0x0",
				"transactionsRoot" => "0x0",
			];
			$transactions = [];
			$uncles = [];
		if(intval($block) > 0){
			$datas = $this->connect->eth_getBlockByNumber('0x'.dechex($block));
			if($datas){
				$data = [
					"number" => $this->connect->decode_hex($datas->number),
					"hash" => $datas->hash,
					"miner" => $datas->miner,
					"extraData" => $datas->extraData,
					"gasLimit" => $this->connect->decode_hex($datas->gasLimit),
					"mixHash" => $datas->mixHash,
					"parentHash" => $datas->parentHash,
					"receiptsRoot" => $datas->receiptsRoot,
					"sha3Uncles" => $datas->sha3Uncles,
					"size" => $datas->size,
					"timestamp" => date('d-m-Y h:i:s',$this->connect->decode_hex($datas->timestamp)),
					"totalDifficulty" => $this->connect->decode_hex($datas->totalDifficulty),
					"stateRoot" => $datas->stateRoot,
					"transactionsRoot" => $datas->transactionsRoot
				];
				$transactions = $datas->transactions;
				$uncles = $datas->uncles;
			}
		}
		if($format == "json"){
			return $this->exportJson(["data" =>$data, "transactions" => $transactions, "uncles" => $uncles]);
		}

		$this->view("block",["data" =>$data, "transactions" => $transactions, "uncles" => $uncles, "controller" => $this->connect]);
	}
}
