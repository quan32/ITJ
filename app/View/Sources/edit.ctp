<table>
<tr>
	<th>ID</th>
	<th>name</th>
	<th>Action</th>
</tr>
<?php
	// print_r($sources);
	foreach ($sources as $source) {
		echo '<tr>';
		echo '<td>'.$source["Source"]["id"].'</td>';
		echo '<td>'.$source["Source"]["filename"].'</td>';
		echo '<td>';
		echo $this->Html->link('Delete', 
			array('action' => 'delete', $source["Source"]["id"]));
		echo '</td>';
		echo '</tr>';
	}
?>
</table> 

<fieldset>
	<legend>Them file</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file'));
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
		echo $this->Form->end('Continue to upload file');
		echo "<button onclick='window.history.back();'>Back</button>";
		echo $this->Html->link('Finish', array('controller'=>'teachers', 'action'=>'index'));
	?>
</fieldset>