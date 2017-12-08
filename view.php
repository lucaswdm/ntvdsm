<?php
































	/*function _encripta($n)
	{
		return str_rot13(strrev(base_convert($n, 10, 30)));
	}*/

	function _decripta($n)
	{
		return base_convert(strrev(str_rot13($n)), 30, 10);
	}

	if(!isset($_GET['v']) || empty($_GET['v'])) exit;
	$ITEMS = array_filter(array_map('trim', explode(',', $_GET['v'])));

	$DM = new Memcached();
    $DM->addServer('localhost', 11211);
    $DM->setOption(Memcached::OPT_BINARY_PROTOCOL,true);

    #var_dump($DM);

    #error_reporting(E_ALL);
    #ini_set('display_errors', true);

	foreach($ITEMS as $k)
	{
		$dados = explode('/', $k);
		#print_r($dados);
		if(is_numeric($dados[0]) && _decripta($dados[1]) == $dados[0])
		{
			$KEY = 'NADS_VIEW_CHAMADA_' . $dados[0] . '_' . date('H-i');
            $ok = $DM->increment($KEY,1,1,600);
		}
	}

	header('Content-Type: image/gif');
	exit(hex2bin('47494638396101000100900000ff000000000021f90405100000002c00000000010001000002020401003b'));

	/*

	echo PHP_EOL;

	foreach( $DM->getallkeys() as $k)
	{
		if(strpos($k, 'DS_VIEW_CHAMA') !== false)
		{
			echo $k .  " --> " . $DM->get($k) . PHP_EOL;
		}
	}
	*/

 ?>
