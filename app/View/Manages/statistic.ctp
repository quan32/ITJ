<h1>毎月のもらったお金</h1>

<?php 

echo $this->Form->create('Manage', array('url' => array('controller' => 'manages', 'action' => 'statistic'))); 
echo $this->Form->input('month', array('label'=>'月', 'options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12')));

echo $this->Form->end(array('label'=>'表現'));

?>

<?php

if ($moneyThisMonth != 0) {

	echo "この月のもらったお金 : ".$moneyThisMonth;
}

?>