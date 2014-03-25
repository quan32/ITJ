<?php if(count($sources)>0): ?>
		<table>
		<tr>
			<th>ID</th>
			<th>タイトル</th>
			<th>管理</th>
		</tr>
		<h1>アップロードしたファイル:</h1>
		<?php
			foreach ($sources as $source) {
				echo '<tr>';
				echo '<td>'.$source["Source"]["id"].'</td>';
				echo '<td>'.$source["Source"]["filename"].'</td>';
				echo '<td>';
				echo $this->Form->postLink('削除', array('controller'=>'sources', 'action'=>'delete', 
					$source["Source"]["id"]), array('confirm'=>'本気？'));
				echo '</td>';
				echo '</tr>';
			}
		?>
		</table> 
	<?php endif ?>


<fieldset>
	<legend>メディアファイルアップロード</legend>

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

		 <div>
			<h5>講義の付き資料として音声ファイルやビデオファイルやイメージファイルなどを選んでください</h5>
			<h5>PDFファイルのみアップロードできる</h5>
			<h5>ファイルを選んでから、ファイルをアップロードするために</h5>
			<h5>「アップロード」ボタンを押してください</h5>
			<h5>付き資料の数は限界ではない</h5>
			<h5>講義の原料の選ぶのが終わったら、「完了」ボタンを押してください</h5>
		 <div>

	<?php
		echo $this->Form->end('アップロード');
		echo "<button onclick='window.history.back();'>戻る　｜</button>";
		echo $this->Html->link('　完成', array('controller'=>'lectures', 'action'=>'index'));
	?>
</fieldset>