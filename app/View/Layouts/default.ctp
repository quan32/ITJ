<!DOCTYPE html>
<html lang="jp">
  <head>
    <script>
      /*/disable right click
      var message="Function Disabled!"; function clickIE4(){ if (event.button==2){ alert(message); return false; } } function clickNS4(e){ if (document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){ alert(message); return false; } } } if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new Function("alert(message);return false");
    
      //disable copy
      function clearData(){
          window.clipboardData.setData('text','') 
      }
      function cldata(){
          if(clipboardData){
              clipboardData.clearData();
          }
      }
      setInterval("cldata();", 1000);*/
     /*
     window.onbeforeunload = function() {
       // Add your code here
       alert("abc");
       return true;
     }*/
      
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_for_layout; ?></title>
    <style type="text/css" media="print">
        * { display: none; }
    </style>
    <style type="text/css">
      .link_buttonx{
        margin:10px;
        margin-top:15px!important;
        font-weight: normal;
        border:1px solid;
        padding-top: 8px;
        padding-right: 10px;
        padding-bottom: 8px;
        padding-left: 10px;
        background-color: #5BA150!important;
        border-radius: 4px;
        color:white!important;
        border-color: #2d6324;
        font-size: 110%;
        
      }
      .search_box select {
        text-transform: none;
        height: 35px;
        width: 55px;
        }

      .tag{
        margin: 2px;
        text-decoration: none!important;
        border: 1px solid #000;
        border-radius: 3px;
        padding: 3px
      }
      .tag:hover{
        background-color: #000;
        color:#fff;
      }
      
    </style>
    <?php
      echo $this->Html->meta('icon');

      echo $this->Html->css('cake.generic');
      echo $this->Html->css('bootstrap');
      echo $this->Html->css('sb-admin');
      echo $this->Html->css('font-awesome.min');
      
      echo $this->fetch('meta');
      echo $this->fetch('css');
      echo $this->fetch('script');
      echo $this->Html->css('mystyle');
    ?>
  </head>
  <!--
  <body ondragstart="return false;" onselectstart="return false;"  oncontextmenu="return false;" onload="clearData();" onblur="clearData();">-->
    <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <?php
                        if($user_role == "teacher")
                            echo $this->Html->link('<span style="font-size:200%;">e</span>ラーニングシステム', 
                                array('controller' => 'teachers',
                                 'action' => 'index'),array('escape'=>false, 'class'=>"navbar-brand"));
                        else if($user_role == "student")
                            echo $this->Html->link('<span style="font-size:200%;">e</span>ラーニングシステム', 
                                array('controller' => 'students',
                                 'action' => 'index'),array('escape'=>false, 'class'=>"navbar-brand"));
                        else if($user_role == "manager")
                            echo $this->Html->link('<span style="font-size:200%;">e</span>ラーニングシステム', 
                                array('controller' => 'manages',
                                 'action' => 'index'),array('escape'=>false, 'class'=>"navbar-brand"));
                    ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <?php 
              echo $this->element($menu_type);
            ?>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="color:white;"><i class="fa fa-user"></i> <?=$temp_username;?><b class="caret"></b></span></a>
              <ul class="dropdown-menu">
                    <li>
                      <?php
                          if($user_role == "teacher")
                              echo $this->Html->link('<i class="fa fa-user"></i> 自身情報', 
                                  array('controller' => 'teachers', 'action' => 'info'),array('escape'=>false));
                          else if($user_role == "student")
                              echo $this->Html->link('<i class="fa fa-user"></i> 自身情報', 
                                  array('controller' => 'students', 'action' => 'viewInfo'),array('escape'=>false));
                          else if($user_role == "manager")
                              echo $this->Html->link('<i class="fa fa-user"></i> 自身情報', 
                                  array('controller' => 'manages', 'action' => 'viewinfo'),array('escape'=>false));
                      ?>
                    </li>
                <li class="divider"></li>
				
				<li class="divider"></li>
                <li><?php 
                  echo $this->Html->link('<i class="fa fa-power-off"></i> ログアウト ', 
                    array('controller' => 'users', 'action' => 'logout'),array('escape'=>false));
                  ?></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <?php echo $this->Html->script('jquery-1.10.2.min');?>
    <?php echo $this->Html->script('bootstrap');?>
<input type="hidden" id="refreshed" value="no">
  </body>
</html>
<script type="text/javascript">
onload=function(){
var e=document.getElementById("refreshed");
if(e.value=="no")e.value="yes";
else{e.value="no";location.reload();}
}
</script>
