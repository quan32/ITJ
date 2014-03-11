<!DOCTYPE html>
<html lang="jp">
  <head>
    <script>
      //disable right click
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
      setInterval("cldata();", 1000);
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_for_layout; ?></title>
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
  <body ondragstart="return false;" onselectstart="return false;"  oncontextmenu="return false;" onload="clearData();" onblur="clearData();">

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand" href="#">eラーニングシステム</a>
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?=$temp_username;?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="fa fa-power-off"></i> Log Out</a></li>
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
  </body>
</html>