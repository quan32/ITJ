<fieldset>
	<legend>情報を変更する</legend>
	<?php 
		echo $this->Form->create('Lecture');
		echo $this->Form->input('category_id',
			array('label'=>'カテゴリ',
				'options'=>array('1'=>'数学','2'=>'文学','3'=>'外国語')));
		echo $this->Form->input('name',array('label'=>'タイトル'));
		echo $this->Form->input('description',array('label'=>'紹介する情報'));	
		echo $this->Form->input('tag',array('label' => 'タグ'));
		echo $this->Form->end('変更');
	?>
</fieldset>
