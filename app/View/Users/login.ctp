<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
        <!-- CSS -->
        <?php echo $this->Html->css('reset');?>
        <?php echo $this->Html->css('supersized');?>
        <?php echo $this->Html->css('style');?>
        <style type="text/css">
.othersd{
    text-align: left;
}
        </style>
</head>
<body>
        <div class="page-container">
			<h1>E-learning System</h1>
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
                <div class="error"><span>+dsdsadsad</span></div>
            <?
                echo $this->Html->link('パスワードを忘れた方', 
                    array('controller' => 'manages', 'action' => 'info2'))."<br><br>";
                echo $this->Html->link('新規登録', 
                    array('controller' => 'users', 'action' => 'role'));
            ?>
            </div>
        </div>
        <div>

        <!-- Javascript -->
        <?php echo $this->Html->script('jquery-1.8.2.min');?>
        <?php echo $this->Html->script('supersized.3.2.7.min');?>
        <?php echo $this->Html->script('supersized-init');?>
</body>
</html>