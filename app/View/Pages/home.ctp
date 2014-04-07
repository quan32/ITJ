<?php
	echo '
	<html>
		<head>
			<meta charset="utf-8">
			<title>eラーニングシステム</title>';
		echo '
		</head>
		<body>';
			echo $this->Html->image('elearning.jpg', array('class' => 'bg'));
			echo '
			<!-- div header -->
			<div id="home-header">
				<h1><span>e</span>ラーニングシステム</h1>
				<h2>より簡単、より速い、より安価</h2>
				<div id="divLogin">';
				echo "<a href='users/login'>".$this->Html->image('login.gif')."</a>";
			echo '
				</div>
			</div>
			<!-- end div header -->

			<!-- div content -->
			<div id="home-content">
				
				<div class="content-box">
					
					<div class="box-left">
						<h1>Welcome</h1>
						
					</div>
					
					<div class="box-right">
						Chào mừng đến với hệ thống e-learning. Hiện nay internet đã rất phát triển. Vì vậy giáo viên, học sinh có thể giảng dạy và học tại nhà bằng hệ thống e-learning. Với hệ thống của chúng tôi, giáo viên sẽ có cơ hội truyền tri thức và cảm hứng của mình tới nhiều học sinh trên mọi miền đất nước, học sinh sẽ được học nhiều giáo viên giỏi với nguồn tài liệu, bài giảng dồi dào, chất lượng.
					</div>

				</div>
				
				<div class="content-box">
					
					<div class="box-left">
						<h1>Mission</h1>
					</div>
					
					<div class="box-right">
						Nhiệm vụ, sứ mệnh của chúng tôi là là tạo một cầu nối giữa giáo viên học sinh không kể khoảng cách địa lý, làm giáo viên hứng khởi trong việc dạy, học sinh năng động, vui vẻ trong việc học.
					</div>

				</div>	

			</div>
			<!-- end div content -->
			
			<!-- div footer -->
			<div id="home-footer">
						
				<!-- icon social network -->
				<div id="icon-sn">';
					// <img src="twitter.png">
					echo '<a href="https://twitter.com">'." ".$this->Html->image('twitter.png').'</a>';
					// <img src="facebook.png">
					echo '<a href="https://www.facebook.com/groups/600915033298033/">'." ".$this->Html->image('facebook.png').'</a>';
					// <img src="google.png">
					echo '<a href="https://www.google.com.vn/">'." ".$this->Html->image('google.png').'</a>';
	echo '
				</div>
				<!-- end icon-sn -->
				<div id="footer-author">
					<h2>@2014 K54の第13チームの<span>e</span>ラーニングシステム</h2>
				</div>
				

			</div>		
			<!-- end div footer -->
		</body>
	</html>
	';
?>

