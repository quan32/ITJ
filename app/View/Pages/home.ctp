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
						<h1>ようこそ</h1>
						
					</div>
					
					<div class="box-right">
						eラーニングシステムへようこそ！</br ></br >
						インターネットの発展により塾などへ行かず、</br >
						自宅で勉強することが出きるようになりました。</br >
						知識を持っている人（先生）と知識を学びたい人（学生）の距離を減らす目的としてeラーニング</br >
						システムを開発しました。このシステムは生活や</br >
						科学などの色んな知識を提供しているものです。</br >
						私たちはシステム内の講義の内容と著作権について責任を持っています。</br >興味がある講義を選んで、勉強しましょう！
					</div>

				</div>
				
				<div class="content-box">
					
					<div class="box-left">
						<h1>ミッション</h1>
					</div>
					
					<div class="box-right">
						システムのミッションは先生方と学生方のブリッジとして、
						距離問題を除き、学びたい人に知識を持ってくるのです。</br >
						貴方の学習の進歩は私たちの責任です。
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

