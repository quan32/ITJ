<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> プロファイル管理 <b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('自身情報', 
		array('controller' => 'students', 'action' => 'viewInfo'));
	?></li>

<li><?php 
echo $this->Html->link('パスワード変更', 
	array('controller' => 'users', 'action' => 'changePassword'));
?></li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> 講義 <b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
echo $this->Html->link('講義リスト', 
	array('controller' => 'students', 'action' => 'lecturesStatistics'));
?></li>

<li><?php 
echo $this->Html->link('お気に入りの講義リスト', 
	array('controller' => 'students', 'action' => 'topLecturesHot'));
?></li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> 受けた講義 <b class="caret"></b></a>
  <ul class="dropdown-menu">
<li><?php 
echo $this->Html->link('一週間以内', 
	array('controller' => 'students', 'action' => 'registedLectureThisWeek'));
?></li>

<li><?php 
echo $this->Html->link('全て', 
	array('controller' => 'students', 'action' => 'registedLectures'));
?></li>
  </ul>
</li>
<li><?php 
echo $this->Html->link('学費', 
	array('controller' => 'students', 'action' => 'moneyStatistics'));
?></li>

<!-- -->