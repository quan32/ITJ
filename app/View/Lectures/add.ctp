<fieldset>
	<legend>Nhap thong tin bai giang moi</legend>
	<?php 
		echo $this->Form->create('Lecture');
		echo $this->Form->input('category_id',
			array('label'=>'Category',
				'options'=>array('1'=>'Toan','2'=>'Van','3'=>'Ngoai ngu')));
		echo $this->Form->input('name');
		echo $this->Form->input('cost');
		echo $this->Form->input('description');	
		echo $this->Form->checkbox('NQ', array('checked' => false));
		echo $this->Form->label('Toi dam bao rang bai giang cung nhung tai lieu lien quan la co ban quyen');
		echo $this->Form->end('Tiep');
	?>
</fieldset>
