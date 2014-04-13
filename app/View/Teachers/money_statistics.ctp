<h1>報酬統計 </h1>

<?php 
echo $this->Form->create('Money'); 

echo "時間 :  ";
if( isset($mos) && isset($yos))
{
echo $this->Form->month('mos', array('monthNames' => false,'value' => $mos,'empty'=>false))."   ";
echo $this->Form->year('yos', 2013, date('Y'), array('value' => $yos,'empty'=>false ));
}
else
{
echo $this->Form->month('mos', array('monthNames' => false,'empty'=>false));
echo $this->Form->year('yos', 2013, date('Y'),array('empty'=>false));	
}
echo $this->Form->end(array('label'=>'表現'));

//Hien so tien mua bai giang cua thang da chon
if(isset($moneyOfTheMonth))
{

if($moneyOfTheMonth > 0)
    echo "<br /><h3>報酬の合計 : ".$moneyOfTheMonth." VND</h3>";
else
	if($moneyOfTheMonth == null)
	echo "この月に、登録られる講義がありません";
}

?>