<div>
	<?php
		echo $this->Form->create('User');
		echo "<fieldset>";
			echo "<legend>";
			echo __('新規会員登録');
			echo "</legend>";
			?>
			
				<div id="loginInfor">
					<fieldset>
						<legend>ログイン情報</legend>
						<?php echo $this->Form->input('username', array('label'=>'ユーザ名'));?>
						<?php echo $this->Form->input('password', array('label'=>'パスワード'));?>
						<?php echo $this->Form->input('mail', array('label'=>'メール'));?>
					</fieldset>
				</div>
				<div id="profileInfor">
					<fieldset>
						<legend>プロフィール情報</legend>
						<?php echo $this->Form->input('fullname', array('label'=>'氏名'));?>
						<?php echo $this->Form->input('date_of_birth', array(
						    'label' => '生年月日',
						    'dateFormat' => 'DMY',
						    'minYear' => date('Y') - 70,
						    'maxYear' => date('Y') - 14,
						));?>
						<?php echo $this->Form->input('sex', array('label'=>'性別', 'options'=>array('man'=>'男','woman'=>'女')));?>
						<?php echo $this->Form->input('address', array('label'=>'住所'));?>
						<?php echo $this->Form->input('credit_card_No', array('label'=>'クレジットカード'));?>
						<?php echo $this->Form->input('mobile_No', array('label'=>'電話番号'));?>
					</fieldset>
				</div>
				
				<?php
			
		echo "</fieldset>";
		echo $this->Form->checkbox('NQ', array('checked' => false));
		echo $this->Form->label('以下の個人情報の取り扱いとウェブサイト規則に同意する');
		?>
		<span id='website_rule'>
			お客様はシステムに登録した個人情報の正しさを確保する必要です。不正行為を発見すると、システムの規則の通り、制裁対策を行うことになっています。他の目的のため、システムに登録した個人情報を利用しないことを確保します。
		</span>
		<?
		echo $this->Form->end(array('label'=>'新規登録'));
	?>
</div>