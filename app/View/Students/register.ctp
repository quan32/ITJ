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
			e-Learning Awardsフォーラムメンバーにご登録いただいた個人情報は、ご本人からのお問合せに対する回答や、電子メール、ダイレクトメールなどによるフォーラム関連情報やeラーニングに関する情報提供時に利用するほか、受講をご予約頂いた講演の演者及びスポンサーに提供されます。ご本人の承諾なしに上記内容の目的以外に利用することはありません。 また、当フォーラムの委託業者が、利用目的の範囲内で情報を使用することがございます。
		</span>
		<?
		echo $this->Form->end(array('label'=>'新規登録'));
	?>
</div>