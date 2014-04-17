<fieldset>
	<legend>新しい講義の情報を入力してください</legend>
	<?php 
		echo $this->Form->create('Lecture');
		echo $this->Form->input('category_id',
			array('label'=>'カテゴリ  ',
				'options'=>array('1'=>'数学','2'=>'文学','3'=>'外国語','4'=>'体育','5'=>'普通科学','6'=>'IT','7'=>'食品','8'=>'社会','9'=>'心理','10'=>'芸術')));
		echo $this->Form->input('name',array('label' => 'タイトル'));
		echo $this->Form->input('description',array('label' => '紹介する情報'));
		echo $this->Form->input('tag',array('label' => 'タグ'));	
		echo $this->Form->checkbox('NQ', array('checked' => false));
		echo $this->Form->label('私はこの講義とこの講義を作成するファイルの著作権について責任をする！');
		echo $this->Form->end('次へ');
	?>
</fieldset>
<style type="text/css">
	label{
		margin-right:10px;
	}
</style>
