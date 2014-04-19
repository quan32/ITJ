<?php if(count($sources)>0): ?>
		<table>
		<tr>
			<th>タイトル</th>
			<th>管理</th>
			<th>タイム</th>
		</tr>
		<h3 padding-bottom="3px">アップロードしたファイル:</h3>
		<?php
			foreach ($sources as $source) {
				echo '<tr>';
				echo '<td>'.$source["Source"]["filename"].'</td>';
				echo '<td>';
				echo $this->Html->link('修正 ', array('controller'=>'sources', 'action'=>'edit1', 
					 $source["Source"]["lecture_id"],$source["Source"]["id"],"add"));
				echo $this->Form->postLink('削除', array('controller'=>'sources', 'action'=>'delete', 
					$source["Source"]["id"]), array('confirm'=>'本気？'));
				echo '</td>';
				echo '<td>'.$source["Source"]["modified"].'</td>';
				echo '</tr>';
			}
		?>
		</table> 
	<?php endif ?>


<fieldset>
	<legend ><br />メディアファイル アップロード</legend>
	<div id="hd1">
			<h5>講義の付き資料として音声ファイルやビデオファイルやイメージファイルなどを選んでください。</h5>
			<h5>PDFファイルのみアップロードできる。ファイルを選んでから、ファイルをアップロードするために,</h5>
			<h5>「アップロード」ボタンを押してください。付き資料の数は限界ではない。</h5>
			<h5>講義の原料の選ぶのが終わったら、「完了」ボタンを押してください。</h5>
		 </div>

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
		echo $this->Html->link('　完成', array('controller'=>'lectures', 'action'=>'index'), array('class'=>'link_buttonx'));
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