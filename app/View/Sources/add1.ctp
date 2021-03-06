<fieldset>
	<legend>講義の添付ファイルを選択してください</legend>
	<div id="hd1">
		 	<h3 padding-bottom="3px">案内</h3>
			<h5>講義の主な資料としてPDFファイルを選んでください。PDFファイルのみアップロードできる。</h5>
			<h5>ファイルを選んでから、ファイルをアップロードするために,「アップロード」ボタンを押してください。</h5>
			<h5>講義の原料の選ぶのが終わったら、「完了」ボタンを押してください。</h5>
		 </div>
	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
	?>

		 <?php if (!empty($this->data['Source']['filepath'])): ?>
			<div class="input">
			<label>添削したファイル</label>
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
		echo $this->Html->link('完成', array('controller'=>'lectures', 'action'=>'index'),array('class'=>'link_buttonx'));
	?>
</fieldset>
<style type="text/css">
	#hd1{
		border:1px dotted;
		padding-left:10px;
	}

	button.link_buttonx{
		height:37px;
	}
</style>