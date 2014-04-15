<h1>メッセージを送る</h1><br />
<?php echo $this->Form->create('Message',array('action'=>'sending'));?>
    <fieldset>
        <legend><?php __('送る');?></legend>
     <?php echo $this->Form->input('message',array('label'=>'メッセージの内容。　入力しなくてもいい。システムはデフォルトの内容のメッセージを送ります！')); ?>
	 <?php echo $this->Form->input('teacher_id', array('type' => 'hidden','value'=>$teacher_id)); ?>
	 <?php echo $this->Form->input('lecture_id', array('type' => 'hidden','value'=>$lecture_id)); ?>
     <?php echo $this->Form->submit('送る'); ?>
    </fieldset>
<?php echo $this->Form->end();?>