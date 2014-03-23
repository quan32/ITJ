<li><?php 
echo $this->Html->link('ホームページ', 
	array('controller' => 'students', 'action' => 'index'));
	?></li>

<li><?php 
echo $this->Html->link('自身情報', 
	array('controller' => 'students', 'action' => 'view_info'));
?></li>
<li><?php 
echo $this->Html->link('講義リスト', 
	array('controller' => 'students', 'action' => 'lectures_statistics'));
?></li>

<li><?php 
echo $this->Html->link('学費', 
	array('controller' => 'students', 'action' => 'money_this_month'));
?></li>

<li><?php 
echo $this->Html->link('テストの結果統計', 
	array('controller' => 'students', 'action' => 'results_statistics'));
?></li>

<li><?php 
echo $this->Html->link('受けた講義リスト', 
	array('controller' => 'students', 'action' => 'registed_lectures'));
?></li>
<li><?php 
echo $this->Html->link('お気に入りの講義リスト', 
	array('controller' => 'students', 'action' => 'top_lectures_hot'));
?></li>

<li><?php 
echo $this->Html->link('パスワード変更', 
	array('controller' => 'users', 'action' => 'changePassword'));
?></li>

<li><?php 
echo $this->Html->link('ログアウト ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>