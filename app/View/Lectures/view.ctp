<?php
	//var_dump($liked_people);die;
	App::import("Model", "Block");
	App::import("Model", "User");
	$BlockModel = new Block();
	$UserModel = new User();
?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<?php echo $this->Html->script('jquery-1.10.2.min');?>
<?php echo $this->Html->css('lecture_view');?>
<div id="container">

<section id="page"> <!-- Defining the #page section with the section tag -->
    <section id="articles"> <!-- A new section with the articles -->
		<!-- Article 1 start -->
        
        <article id="article1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
		<h3 id="lecture-title"><?=$lecture['Lecture']['name']?></h3>
            
            <div class="line"></div>
            
            <div class="articleBody clear">
            	<h4>作者: <?= $UserModel->username($lecture['Lecture']['user_id']); ?></h4>
                <p><?=$lecture['Lecture']['description']?></p>
            </div>
           		<?= $user_role == 'student' ? 
           			$this->Html->link(' テストリスト',array('controller' => 'Students','action' => 'viewListTest',$register_item ))
           			: $this->Html->link(' テストリスト',array('controller' => 'Tests','action' => 'index',$lecture['Lecture']['id'] )); 
       			?>
        </article>
        
		<!-- Article 1 end -->


		<!-- Article 2 start -->
        
        <article id="article2">
            <h2>講義内容</h2>
            <?php
            	if(!isset($pdf_id)){
            		echo "<span class='pdf_error'>講義内容は削除させられてしまった。</span>";
            	}else{

            		if($pdf_state == "normal"){
            			?>

							<div class="line"></div>
				            
				            <div class="articleBody clear">
				                <?php
								if(isset($src)){
								?>
									<iframe width="100%" height="600" src="<?php echo $src;?>"></iframe>
								<?php }?>
				            </div>



            			<?php

						if($role=='manager'){
	            			echo "<div class='source_block'>";
	            			echo $this->Html->link('ブロック  ', array('controller'=>'sources', 'action'=>'block', $pdf_id));
	            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $pdf_id));
	            			echo "</div>";
            			}




            		}elseif($pdf_state == "blocked"){
            			if($role=='manager'){
            				?>
	            				<div class="line"></div>
					            
					            <div class="articleBody clear">
					                <?php
									if(isset($src)){
									?>
										<iframe width="100%" height="600" src="<?php echo $src;?>"></iframe>
									<?php }?>
					            </div>

            				<?php
            				echo "<div class='source_block'>";
	            			echo $this->Html->link('アンチブロック  ', array('controller'=>'sources', 'action'=>'unblock', $pdf_id));
	            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $pdf_id));
	            			echo "</div>";
            			}elseif($role=='teacher'){
            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span>";
            			}else{
            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span>";
            			}

            		}
	            	
            	}
            ?>
            
        </article>
        
		<!-- Article 2 end -->
		
		<!-- Article 3 start -->
        
        <article id="article2">
            <h2>MP3</h2>
            
            <div class="line"></div>
            
            <div class="articleBody clear">
                
				<?php
					foreach ($sources as $source) {
						if($source['type']=='audio/mpeg' || $source['type']=='audio/mp3' || $source['type']=='audio/wav'){
								$name = $source['filename'];

							if($source['state'] == "normal"){
		            			?>

									<audio controls>
									  <source src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>" type="audio/mpeg">
									  Your browser does not support this audio format.
									</audio>
									



		            			<?php

								if($role=='manager'){
			            			echo "<div class='source_block'>";
			            			echo $this->Html->link('ブロック  ', array('controller'=>'sources', 'action'=>'block', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}




		            		}elseif($source['state'] == "blocked"){
		            			if($role=='manager'){
		            				?>
				            			<audio controls>
									  <source src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>" type="audio/mpeg">
									  Your browser does not support this audio format.
									</audio>
									

		            				<?php
		            				echo "<div class='source_block'>";
			            			echo $this->Html->link('アンチブロック  ', array('controller'=>'sources', 'action'=>'unblock', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}elseif($role=='teacher'){
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}else{
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}

		            		}




							}
						}
				?>
            </div>
        </article>


        <article id="article2">
            <h2>メディアファイル</h2>
            
            <div class="line"></div>
            
            <div class="articleBody clear">
                
				<?php
					foreach ($sources as $source) {
						if($source['type']=='video/mp4'){
							$name = $source['filename'];

							if($source['state'] == "normal"){
		            			?>

									<video width="320" height="240" controls>
									  <source src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>" type="video/mp4">
									  Your browser does not support the video tag.
									</video>
									<br><br>



		            			<?php

								if($role=='manager'){
			            			echo "<div class='source_block'>";
			            			echo $this->Html->link('ブロック  ', array('controller'=>'sources', 'action'=>'block', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}




		            		}elseif($source['state'] == "blocked"){
		            			if($role=='manager'){
		            				?>
				            			<video width="320" height="240" controls>
										  <source src="http://localhost/ITJ/app/webroot/uploads/<?echo $source['filename'];?>" type="video/mp4">
										  Your browser does not support the video tag.
										</video>
										<br><br>

		            				<?php
		            				echo "<div class='source_block'>";
			            			echo $this->Html->link('アンチブロック  ', array('controller'=>'sources', 'action'=>'unblock', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}elseif($role=='teacher'){
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}else{
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}

		            		}




							}
						}
				?>
            </div>
        </article>        
		<!-- Article 3 end -->

		<!-- Article 3 start -->
        
        <article id="article2">
            <h2>イメージ</h2>
            <div class="line"></div>
            
            <div class="articleBody clear">
                
				<?php
					foreach ($sources as $source) {
						if(in_array($source['type'], array('image/gif','image/png','image/jpg','image/jpeg'))){
								

							if($source['state'] == "normal"){
		            			?>

									<img src="http://localhost/ITJ/app/webroot/uploads/<?php echo $source['filename'];?>">
									<br>



		            			<?php

								if($role=='manager'){
			            			echo "<div class='source_block'>";
			            			echo $this->Html->link('ブロック  ', array('controller'=>'sources', 'action'=>'block', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}




		            		}elseif($source['state'] == "blocked"){
		            			if($role=='manager'){
		            				?>
			            				<img src="http://localhost/ITJ/app/webroot/uploads/<?php echo $source['filename'];?>">
										<br>

		            				<?php
		            				echo "<div class='source_block'>";
			            			echo $this->Html->link('アンチブロック  ', array('controller'=>'sources', 'action'=>'unblock', $source['id']));
			            			echo $this->Html->link('削除', array('controller'=>'sources', 'action'=>'managerDelete', $source['id']));
			            			echo "</div>";
		            			}elseif($role=='teacher'){
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}else{
		            				echo "<span class='pdf_error'>このファイルは管理者によってブロックさせられた。</span><br><br>";
		            			}

		            		}




							}
						}
				?>
            </div>
        </article>
        
		<!-- Article 3 end -->

		<!-- Article 4 start -->
        
        <article id="article2">
            <h2>タグ一覧</h2>
            
            <div class="line"></div>
            
            <div class="articleBody clear">
                
				<?php
					if(isset($tags)){
						foreach ($tags as $tag) {
						 // echo "<a class='tag' href='/ITJ/tags/view/".$tag['Tag']['id']."'>".$tag['Tag']['content']."</a>";
						 echo $this->Html->link($tag['Tag']['content'], array('controller'=>'tags', 'action'=>'view', $tag['Tag']['id']), array('class'=>'tag'));
						}
					}
					
				?>
            </div>
        </article>
        
		<!-- Article 4 end -->
		
		<!-- Article 5 start -->
        
        <article id="article2">
            <h2>コメント</h2>
            
            <div class="line"></div>
            
            <div class="articleBody clear">
                <?php if($isLiked==0): ?>
					<button id="like_button" class="link_buttonx">いいね！</button>
					<button id="dislike_button" class="link_buttonx" style="display:none">取り消す</button>
				<?php else: ?>
					<button id="like_button" class="link_buttonx" style="display:none">いいね！</button>
					<button id="dislike_button" class="link_buttonx">取り消す</button>
				<?php endif ?>
				<em id="num_liked"><?=$num_liked?></em> 人はこの講義について「いいね！」
				<?php
					foreach ($liked_people as $user) {
						if($user['user_id'] == $current_user_id) continue;
						echo '<em>'.$UserModel->username($user['user_id']).'</em>'.', ';
					}
				?>
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
										<p><a href="" class="author">あなた</a></p>
										<textarea class="reply_text" id="<?= $value['Comment']['id']; ?>">コメントを投稿する...</textarea>
									</div>
								</li>
							</ul>
						</li>
					<?php endforeach; ?>

					<li class="comment<?= $lecture['Lecture']['id']; ?>">					
						<div class="comment_text">
							<p><a href="" class="author">あなた</a></p>
							<textarea class="comment_text" id="<?= $lecture['Lecture']['id']; ?>">コメントを投稿する...</textarea>
						</div>
					</li>
				</ul>
            </div>
        </article>
    </section>
    
</section>


	
</div>

<script type="text/javascript">
$(document).ready(function(){
	//prevent print screen
	$(document).keyup(function(e){
		if(e.keyCode == 44) {
			$("body").hide();
			window.clipboardData.setData('text','');
		}
	});

	//
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
		    		//$(".nested-comments-complex").load(window.location.href);
		    		window.location.reload(true);
		        }
		    });
	     }
	}).focus(function(){
	    if(this.value == "コメントを投稿する..."){
	         this.value = "";
	    }

	}).blur(function(){
	    if(this.value==""){
	         this.value = "コメントを投稿する...";
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
    	if (confirm("Doこの学生をブロックは本気？")) {
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
    	if (confirm("この学生をアンブロックは本気？")) {
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
<!-- Disable Copy and Paste-->
<script language='JavaScript1.2'>
	function disableselect(e){
	return false
}
function reEnable(){
	return true
}
document.onselectstart=new Function (&quot;return false&quot;)
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
</script>

<style type="text/css">
	button.link_buttonx{
		height:37px;
	}
	.source_block{
		text-align: right;
	}
	span.pdf_error{
		color:red;
	}
</style>