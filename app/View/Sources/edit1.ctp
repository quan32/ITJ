<fieldset>
	<legend ><br />ファイル修正</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
	?>

		 <?php if (!empty($this->data['Source']['filepath'])): ?>
			<div class="input">
			<label>アップロードしたファイル</label>
			<?php
			echo $this->Form->input('filepath', array('type'=>'hidden'));
			echo $this->Html->link(basename($this->data['Source']['filepath']), $this->data['Source']['filepath']);
			?>
		</div> 
	<?php else: ?>
		<?php echo $this->Form->input('filename',array(
			'type' => 'file'
		)); ?>
		 <?php endif; ?> 

	<?php
		echo $this->Form->end('アップロード');
		echo '<button class = "link_buttonx"'." onclick='window.history.back();'>戻る</button>";
		
		// echo $this->Html->link('　完成', array('controller'=>'lectures', 'action'=>'index'), array('class'=>'link_buttonx'));
	?>
</fieldset>

<style type="text/css">
	#hd1{
		border:1px dotted;
		padding-left:10px;
	}

	button{
		height:37px;
	}
	h3{
		color:red!important;
		font-weight: bold;
	}
</style>