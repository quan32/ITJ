<div>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __("資格を選んでください"); ?></legend>
		<?php 
		echo $this->Form->input('role',
			array('label'=>'資格',
				'options'=>array('student'=>'学生',
				'teacher'=>'先生')));
		?>
	</fieldset>
	<div class="button_arrange">
		<?php echo $this->Html->link('戻る', array('controller'=>'users', 'action'=>'login'), array('class'=>'link_buttonx'));?>
		<?php echo $this->Form->end(array('label'=>'次へ')); ?>
	</div>
</div>

<style type="text/css">
	  div.button_arrange{
        position: absolute;
      }
      .link_buttonx{
      	height: 40px;
        float:left;
        margin-right:30px;
        margin-left:0px!important;
      }
      div.button_arrange div{
      	width:300px;
      	clear:right;
      }
	
</style>