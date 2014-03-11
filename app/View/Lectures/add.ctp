<fieldset>
	<legend>新しい講義の情報を入力してください</legend>
	<?php 
		echo $this->Form->create('Lecture');
		echo $this->Form->input('category_id',
			array('label'=>'カテゴリ',
				'options'=>array('1'=>'数学','2'=>'文学','3'=>'外国語')));
		echo $this->Form->input('name',array('label' => 'タイトル'));
		echo $this->Form->input('description',array('label' => '紹介する情報'));	
		echo $this->Form->checkbox('NQ', array('checked' => false));
		echo $this->Form->label('私は著作権の問題と関係する責任を受信する！');
		echo $this->Form->end('次へ');
	?>
</fieldset>
