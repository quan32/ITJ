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
				echo "<a href='users/login'>".$this->Html->image('login.png')."</a>";
			echo '
				</div>
			</div>
			<!-- end div header -->

			<!-- div content -->
			<div id="home-content">
				
				<div class="content-box">
					
					<div class="box-left">
						<h1>ようこそ</h1>
						Tận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thực
					</div>
					
					<div class="box-right">
						Tận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thựcTận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thực
					</div>

				</div>
				
				<div class="content-box">
					
					<div class="box-left">
						Tận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thực
					</div>
					
					<div class="box-right">
						Tận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thựcTận dụng nguồn sức mạnh đó, xuất phát từ tình yêu đối với thành phố Hà Nội và sự đam mê yêu thích du lịch, em muốn chia sẻ tình yêu đó, lòng đam mê đó với tất cả mọi người có sự quan tâm đến các danh lam thắng cảnh, địa điểm văn hóa, lịch sử, ẩm thực
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

