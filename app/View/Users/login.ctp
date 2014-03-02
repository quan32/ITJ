<div>
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('User'); ?>

	<fieldset>
		<legend>
			<?php echo __('<h1>ユーザ名とパスワードを入力してください</h1>'); ?>
		</legend>
		<?php echo $this->Form->input('username', array('label'=>'ユーザ名'));
		echo $this->Form->input('password', array('label'=>'パスワード'));
		echo $this->Form->checkbox('Save', array('checked'=>false));
		echo "保存する";
		echo $this->Html->link('初期パスワードに設定する', 
			array('controller' => 'users', 'action' => 'reset'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>'ログイン')); ?>
</div>
<?php
	echo $this->Html->link('新規登録', 
		array('controller' => 'users', 'action' => 'role'));
?>