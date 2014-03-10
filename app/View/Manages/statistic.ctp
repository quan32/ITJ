<h1>Hien thi so tien hang thang' nhan duoc </h1>

<?php 

echo $this->Form->create('Manage', array('url' => array('controller' => 'manages', 'action' => 'statistic'))); 
echo $this->Form->input('month', array('label'=>'Month', 'options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12')));

echo $this->Form->end(array('label'=>'View'));

?>

<?php

if ($moneyThisMonth != 0) {

	echo "So tien thang da chon : ".$moneyThisMonth;
}

?>