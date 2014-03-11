<h1>新管理者追加</h1>
<div>
	<?php
		echo $this->Form->create('User');
		echo "<fieldset>";
			?>

				<div id="loginInfor">
					<fieldset>
						<legend>ログイン情報</legend>
						<?php echo $this->Form->input('username', array('label'=>'ユーザ名'));?>
						<?php echo $this->Form->input('password', array('label'=>'パスワード'));?>
						<?php echo $this->Form->input('mail', array('label'=>'メール'));?>
						<?php echo $this->Form->input('verify', array('label'=>'Verifyコード'));?>
					</fieldset>
				</div>
				<div id="profileInfor">
					<fieldset>
						<legend>プロフィール情報</legend>
						<?php echo $this->Form->input('fullname', array('label'=>'氏名'));?>
						<?php echo $this->Form->input('date_of_birth', array('label'=>'生年月日'));?>
						<?php echo $this->Form->input('sex', array('label'=>'性別', 'options'=>array('man'=>'男',
									'woman'=>'女')));?>
						<?php echo $this->Form->input('address', array('label'=>'住所'));?>
						<?php echo $this->Form->input('bank_acc', array('label'=>'銀行口座'));?>
						<?php echo $this->Form->input('mobile_No', array('label'=>'電話番号'));?>
					</fieldset>
				</div>

				<?php
			
		echo "</fieldset>";
		echo $this->Form->end(array('label'=>'完了'));
	?>
</div>