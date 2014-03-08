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
	em.reply-link{
		text-decoration: none;
		font-size: 0.8em;
		color: #777;
		font-style: normal;
		font-weight: bold;
	}
</style>
noi dung bai giang o day
<hr>
<div id="container">
	<ul class="nested-comments-complex">

		<?php foreach ($comments as $value): ?>
			<li>
				<div class="comment">
					<p><a href="" class="author"><?= $value['Comment']['user_id']; ?></a></p>
					<p><?= $value['Comment']['content']; ?></p>
					<em><?= $value['Comment']['created']; ?></em> <em class="reply-link" id="reply<?= $value['Comment']['id']; ?>">Reply</em>
				</div>
				<ul>
					<?php foreach ($value['Reply'] as $reply): ?>
						<li>
							<div class="comment">
								<p><a href="" class="author"><?= $reply['user_id']; ?></a></p>
								<p><?= $reply['content']; ?></p>
								<em><?= $reply['created']; ?></em>
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

		<li class="comment<?= $lecture_id; ?>">					
			<div class="comment_text">
				<p><a href="" class="author">Current User</a></p>
				<textarea class="comment_text" id="<?= $lecture_id; ?>">Write your comment here...</textarea>
			</div>
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
  	$(".reply-link").click(function(){
    	var id = $(this).attr('id');
    	$("li#"+id).toggle();
  	});

  	//textarea event
  	$('textarea').keydown(function(event) {
	    if (event.keyCode == 13 && ! event.shiftKey) {
	        //$(this.form).submit()
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
	        var l = window.location;
			var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
	        $.ajax({
		        url: base_url+"/comments/add",//TODO thay bang duong dan khac
		        type: "POST",
		        data: send_data,
		        success: function(data) {
		            console.log(data);
		    		window.location.reload(true);
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
});
</script>