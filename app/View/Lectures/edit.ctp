<fieldset>
	<legend>Thay doi thong tin</legend>
	<?php 
		echo $this->Form->create('Lecture');
		echo $this->Form->input('category_id',
			array('label'=>'Category',
				'options'=>array('1'=>'Toan','2'=>'Van','3'=>'Ngoai ngu')));
		echo $this->Form->input('name');
		echo $this->Form->input('cost');
		echo $this->Form->input('description');	
		echo $this->Form->end('Thay doi');
	?>
</fieldset>
