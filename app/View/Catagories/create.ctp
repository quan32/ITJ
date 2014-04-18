<h1>新しいカテゴリを作成</h1>
<?php
	echo $this->Form->create('Catagory');
	echo $this->Form->input('name',array('label' => 'タイトル'));
	echo $this->Form->end('次へ');
?>