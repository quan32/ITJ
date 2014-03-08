<?
if(count($sources)>0){
	?>
		<table>
		<tr>
			<th>ID</th>
			<th>name</th>
			<th>Action</th>
		</tr>
		<h1>File da upload:</h1>
		<?php
			foreach ($sources as $source) {
				echo '<tr>';
				echo '<td>'.$source["Source"]["id"].'</td>';
				echo '<td>'.$source["Source"]["filename"].'</td>';
				echo '<td>';
				echo $this->Form->postLink('Delete', array('controller'=>'sources', 'action'=>'delete', 
					$source["Source"]["id"]), array('confirm'=>'Ban co chac khong?'));
				echo '</td>';
				echo '</tr>';
			}
		?>
		</table> 
	<?
}
?>


<fieldset>
	<legend>Them file Media</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
	?>

		 <?php if (!empty($this->data['Source']['filepath'])): ?>
			<div class="input">
			<label>Uploaded File</label>
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
		echo $this->Form->end('Upload');
		echo "<button onclick='window.history.back();'>Back</button>";
		echo $this->Html->link('Finish', array('controller'=>'lectures', 'action'=>'index'));
	?>
</fieldset>