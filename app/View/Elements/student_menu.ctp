<li><?php 
echo $this->Html->link('ホームページ', 
	array('controller' => 'students', 'action' => 'index'));
	?></li>

<li><?php 
echo $this->Html->link('自身情報', 
	array('controller' => 'students', 'action' => 'viewInfo'));
?></li>
<li><?php 
echo $this->Html->link('講義リスト', 
	array('controller' => 'students', 'action' => 'lecturesStatistics'));
?></li>

<li><?php 
echo $this->Html->link('学費', 
	array('controller' => 'students', 'action' => 'moneyStatistics'));
?></li>

<li><?php 
echo $this->Html->link('テストの結果統計', 
	array('controller' => 'students', 'action' => 'resultsStatistics'));
?></li>

<li><?php 
echo $this->Html->link('受けた講義リスト', 
	array('controller' => 'students', 'action' => 'registedLectures'));
?></li>
<li><?php 
echo $this->Html->link('気に入りの講義リスト', 
	array('controller' => 'students', 'action' => 'topLecturesHot'));
?></li>

<li><?php 
echo $this->Html->link('パスワード変化', 
	array('controller' => 'users', 'action' => 'changePassword'));
?></li>

<li><?php 
echo $this->Html->link('ログアウト ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>