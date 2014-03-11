<li><?php 
echo $this->Html->link('ホームページ', 
	array('controller' => 'teachers', 'action' => 'index'));
	?></li>

<li><?php 
echo $this->Html->link('自身情報', 
	array('controller' => 'teachers', 'action' => 'info'));
?></li>

<li><?php 
echo $this->Html->link('新しい講義を作成 ', 
	array('controller' => 'lectures', 'action' =>'add'));
?></li>

<li><?php 
echo $this->Html->link('講義をマネジメント ', 
	array('controller' => 'lectures', 'action' =>'index'));
?></li>

<li><?php 
echo $this->Html->link('パスワード変化', 
	array('controller' => 'users', 'action' => 'changePassword'));
?></li>

<li><?php 
echo $this->Html->link('結果を表現', 
	array('controller' => 'teachers', 'action' => 'viewResult'));
?></li>

<li><?php 
echo $this->Html->link('統計値', 
	array('controller' => 'teachers', 'action' => 'statistic'));
?></li>

<li><?php 
echo $this->Html->link('ログアウト ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>

