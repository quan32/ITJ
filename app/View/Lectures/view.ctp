<?php
	App::import("Model", "Block");
	App::import("Model", "User");
	$BlockModel = new Block();
	$UserModel = new User();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style type="text/css">
	a {
		color: #618CC7;
	}

	ul.nested-comments-complex {
		width: 700px;
		margin: 5em auto;
		border: 1px solid #777;
	}
	ul, ol, li {
		list-style: none;
	}

	em {
		font-size: 0.75em;
		color: #777;
		font-style: italic;
	}

	ul.nested-comments-complex li {
		margin: 0 3em;
	}

	ul.nested-comments-complex li ul {
		position: relative;
	}

	ul.nested-comments-complex li ul::before {
		content: '';
		position: absolute;
		width: 2em;
		top: 2em;
		height: 5px;
	}

	div.comment {
		background: white;
		/*border: 1px solid #999;*/
		padding: 0.5em;
		margin-bottom: 0;
	}
	ul.nested-comments-complex textarea{
		height: 3em;
		resize:vertical;
		font-size: 14px;
	}

	ul.nested-comments-complex p{
		margin: 0 0 0.5em;
	}
	a.action{
		text-decoration: none;
		font-size: 0.8em;
		color: #777;
		font-style: normal;
		font-weight: bold;
	}
	a.action:hover{
		text-decoration:underline;
		cursor:pointer;
	}
</style>
<div id="container">
	<div id="lecture_content">
		<h1 id="lecture-title"><?=$lecture['Lecture']['name']?></h1>
		<div id="description"><?=$lecture['Lecture']['description']?></div>
		<?php
		if(isset($src)){
		?>
			<iframe width="723" height="756" src="<?php echo $src;?>"></iframe>
		<?php }?>

		<h1>Media file</h1>
		<?php
			foreach ($sources as $source) {
					if($source['type']=='video/x-flv'){
						$name = $source['filename'];
						?>
							<h1>Media<?echo $source['id'];?></h1>
							<object classid="" codebase=" " width="352" height=" 308" align="middle">
						    <param name="FlashVars" value="">
						    <param name="movie" value="">
						    <param name="quality" value="high">
						    <param name="allowScriptAccess" value="always"><param name="wmode" value="transparent"><param name="base" value="http://d.violet.vn/plugins/flash/">
						    <embed src="http://localhost/ITJ/app/webroot/files/flvPlayer.swf" quality="high" width="352" height="308"align="middle" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" base=""  flashvars="file=http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>">
							</object>
						<?php
					}elseif(in_array($source['type'], array('image/gif','image/png','image/jpg','image/jpeg'))){
						?>
							<h2>Image <? echo $source['id'];?></h2>
							<img src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>">
						<?php
					}
				}
		?>
	</div>
	<?php if($isLiked==0): ?>
		<button id="like_button">Like</button>
		<button id="dislike_button" style="display:none">Dislike</button>
	<?php else: ?>
		<button id="like_button" style="display:none">Like</button>
		<button id="dislike_button">Dislike</button>
	<?php endif ?>
<em id="num_liked"><?=$num_liked?></em> nguoi da thich bai nay
	<ul class="nested-comments-complex">
		<?php foreach ($comments as $value): ?>
			<li>
				<div class="comment">
					<p><a href="" class="author"><?= $UserModel->username($value['Comment']['user_id']); ?></a></p>
					<p><?= $value['Comment']['content']; ?></p>
					<em><?= $value['Comment']['created']; ?></em>
					<a class="reply-link action" id="reply<?= $value['Comment']['id']; ?>">Reply</a>
					<?php if($current_user_id==$lecture['Lecture']['user_id'] &&  $current_user_id!= $value['Comment']['user_id']){
						if($BlockModel->isBlocked($current_user_id,$value['Comment']['user_id'])){
							//da block
							echo "<a class='unblock-link action' id='".$value['Comment']['user_id']."'>Unblock</a>";
							echo "<a class='block-link action' id='".$value['Comment']['user_id']."' style='display:none;'>Block</a>";
						}
						else{
							echo "<a class='block-link action' id='".$value['Comment']['user_id']."'>Block</a>";
							echo "<a class='unblock-link action' id='".$value['Comment']['user_id']."' style='display:none;'>Unblock</a>";
						}
					}

						
					?>

				</div>
				<ul>
					<?php foreach ($value['Reply'] as $reply): ?>
						<li>
							<div class="comment">
								<p><a href="" class="author"><?= $UserModel->username($reply['user_id']); ?></a></p>
								<p><?= $reply['content']; ?></p>
								<em><?= $reply['created']; ?></em>
								<?php 
									if($current_user_id==$lecture['Lecture']['user_id'] &&  $current_user_id!= $reply['user_id']){
										if($BlockModel->isBlocked($current_user_id,$reply['user_id'])){
											//da block
											echo "<a class='unblock-link action' id='".$reply['user_id']."'>Unblock</a>";
											echo "<a class='block-link action' id='".$reply['user_id']."' style='display:none;'>Block</a>";
										}
										else{
											echo "<a class='block-link action' id='".$reply['user_id']."'>Block</a>";
											echo "<a class='unblock-link action' id='".$reply['user_id']."' style='display:none;'>Unblock</a>";
										}
									}
								?>
							</div>
						</li>
					<?php endforeach; ?>
					<li id="reply<?= $value['Comment']['id']; ?>" style="display:none;">					
						<div class="comment">
							<p><a href="" class="author">Current User</a></p>
							<textarea class="reply_text" id="<?= $value['Comment']['id']; ?>">Write your comment here...</textarea>
						</div>
					</li>
				</ul>
			</li>
		<?php endforeach; ?>

		<li class="comment<?= $lecture['Lecture']['id']; ?>">					
			<div class="comment_text">
				<p><a href="" class="author">Current User</a></p>
				<textarea class="comment_text" id="<?= $lecture['Lecture']['id']; ?>">Write your comment here...</textarea>
			</div>
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var lecture_id = <?=$lecture['Lecture']['id']?>;
    var l = window.location;
	var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
  	$(".reply-link").click(function(){
    	var id = $(this).attr('id');
    	$("li#"+id).toggle();
  	});

  	//textarea event
  	$('textarea').keydown(function(event) {
	    if (event.keyCode == 13 && ! event.shiftKey) {
	        var data = {};
	        data['Comment'] ={};
	        data['Comment']['content'] = $(this).val();
	        if($(this).attr('class')=="reply_text"){
	        	data['Comment']['parent_id'] = $(this).attr('id');
	        } else if($(this).attr('class')=="comment_text"){
	        	data['Comment']['lecture_id'] = $(this).attr('id');
	        }
	        var send_data = {};
	        send_data['data'] = data;
	        $.ajax({
		        url: base_url+"/comments/add",//TODO thay bang duong dan khac
		        type: "POST",
		        data: send_data,
		        success: function(data) {
		            console.log(data);
		    		$(".nested-comments-complex").load(window.location.href);
		        }
		    });
	     }
	}).focus(function(){
	    if(this.value == "Write your comment here..."){
	         this.value = "";
	    }

	}).blur(function(){
	    if(this.value==""){
	         this.value = "Write your comment here...";
	    }
	});
	//like
	$('#like_button').click(function(){
        $.ajax({
	        url: base_url+"/favorites/add",
	        type: "POST",
	        data: {'lecture_id': lecture_id},
	        success: function(data) {
	            console.log(data);
	            num_liked = parseInt($('#num_liked').html());
	            $('#num_liked').html(num_liked+1);
	            $('#like_button').hide();
	            $('#dislike_button').show();
	        }
	    });

  	});
  	//dislike
  	$('#dislike_button').click(function(){
        $.ajax({
	        url: base_url+"/favorites/delete",
	        type: "POST",
	        data: {'lecture_id': lecture_id},
	        success: function(data) {
	            console.log(data);
	            num_liked = parseInt($('#num_liked').html());
	            $('#num_liked').html(num_liked-1);
	            $('#dislike_button').hide();
	            $('#like_button').show();

	        }
	    });

  	});
  	//block
  	$(".block-link").click(function(){
  		var tmp = $(this);
    	var student_id = $(this).attr('id');
    	if (confirm("Do you want to block this student?")) {
    		$.ajax({
		        url: base_url+"/blocks/add",
		        type: "POST",
		        data: {'student_id': student_id},
		        success: function(data) {
		            console.log(data);
		            console.log($(this));
		            tmp.hide();
		            tmp.parent().find(".unblock-link").show();
		        }
	    	});
    	}
  	});
  	//unblock
  	$(".unblock-link").click(function(){
  		var tmp = $(this);
    	var student_id = $(this).attr('id');
    	if (confirm("Do you want to unblock this student?")) {
    		$.ajax({
		        url: base_url+"/blocks/delete",
		        type: "POST",
		        data: {'student_id': student_id},
		        success: function(data) {
		            console.log(data);
		            tmp.hide();
		            tmp.parent().find(".block-link").show();
		        }
	    	});
    	}
  	});
});
</script>