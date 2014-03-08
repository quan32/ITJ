<!DOCTYPE html>
<html>
<head>
<title>Search Box Example 1</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<!-- CSS styles for standard search box -->
<style type="text/css">
	#tfheader{
		background-color:#c3dfef;
	}
	#tfnewsearch{
		float:right;
		padding:20px;
	}
	.tftextinput{
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		border:1px solid #0076a3; border-right:0px;
		border-top-left-radius: 5px 5px;
		border-bottom-left-radius: 5px 5px;
	}
	.tfbutton {
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		outline: none;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		color: #ffffff;
		border: solid 1px #0076a3; border-right:0px;
		background: #0095cd;
		background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
		background: -moz-linear-gradient(top,  #00adee,  #0078a5);
		border-top-right-radius: 5px 5px;
		border-bottom-right-radius: 5px 5px;
	}
	.tfbutton:hover {
		text-decoration: none;
		background: #007ead;
		background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
		background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	}
	/* Fixes submit button height problem in Firefox */
	.tfbutton::-moz-focus-inner {
	  border: 0;
	}
	.tfclear{
		clear:both;
	}
</style>
</head>
<body>
	<!-- HTML for SEARCH BAR -->
	<div id="tfheader">
		<form id="searchform" method="post" action="index">
		        <input type="text" class="tftextinput" name="q" size="21" maxlength="120" placeholder="Enter teacher's name or lecture information">
				<input type="submit" value="search" class="tfbutton">
		</form>
	<div class="tfclear"></div>
	</div>
	<div id="data">
		<?php if($lectureinfo!= NULL)
		{
		echo count($lectureinfo); 
		echo "<table>
          <tr>
            <th>ID</th>
            <th>Ten bai giang</th>
            <th>Mo ta</th>
            <th>Gia</th>
			<th>Giao vien thuc hien</th>
            <th>so hoc sinh dang ki</th>
			<th>Dang ky ngay</th>
          </tr>";
		 foreach($lectureinfo as $lecture){
			echo "<tr>";
			echo "<td>".$lecture['Search']['id']."</td>";
			echo "<td>".$lecture['Search']['name']."</td>";
			echo "<td>".$lecture['Search']['description']."</td>";
			echo "<td>".$lecture['Search']['cost']."</td>";
			echo "<td>".$lecture['User']['fullname']."</td>";
			echo "<td>".count($lecture['Register'])."</td>";
			echo " <td>"."<a href=''>Dang ky ngay</a>"."</td>";
			echo "</tr>";
		}
		echo "</table>";
		}
		?>
	</div>
	
</body>
</html>
