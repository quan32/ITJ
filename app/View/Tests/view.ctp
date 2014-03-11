<meta http-equiv="Content-Type" content="text/html; charset=SJIS">
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<?php echo $this->Html->script('jquery-1.10.2.min');?>
<?php
	//Hien thi form
	echo $this->Form->create('Questions', array('url' => array('controller' => 'tests', 'action' => 'view_result')));
	echo $this->Form->input('test_id', array('value'=>$test_id,'type'=>'hidden') );
	$count = 1;
	foreach ($tests as $question) {
		echo "<br>";
		echo $count.". ".$question['qs']."<br>";
		//answer choice
		$attributes = array(
		    'legend' => false,
		    'separator' => '<br>'
		    //'checked'=> ($foo == "pro") ? FALSE : TRUE,
		);
		echo $this->Form->radio($count.'.answer', $question['s'], $attributes);

		$count++;
	}
	echo $this->Form->end(array('label'=>'送付'));
?>
<script type="text/javascript">
$(function() {
    //TODO auto submit form after a time
});
</script>