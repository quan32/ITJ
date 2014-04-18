<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
 <style type="text/css">
body{
   <?= 'background: url("")'; ?>
}
.others{
    text-align: left;
}
.other-functions{
    margin-top: 15px;
}
a, a:visited
{ 
color:white;
font-weight: bold;
}
</style>

</head>
<body>
        <div class="page-container">
			<h1><span style="font-size:200%;">e</span>ラーニングシステムの管理者ログイン画面</h1>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Form->create('User'); ?>
            <?php echo $this->Session->flash(); ?>
            <fieldset>
                <?php echo $this->Form->input('username', array('label'=>false,'placeholder'=>"Username"));
                echo $this->Form->input('password', array('label'=>false,'placeholder'=>"Password"));
                ?>
            </fieldset>
            <div class="others">
            <?php echo $this->Form->end(array('label'=>'ログイン')); ?>
            </div>
        </div>
        <div>

       
</body>
</html>