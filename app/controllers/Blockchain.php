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

		$arv = [
			"blocknumer" => $blockLast,
			"peer" => $this->connect->net_peerCount(true),
			"transactions" => $arvs,
			"blocks" => $blocks
		];
		$this->exportJson($arv);
	}
}
