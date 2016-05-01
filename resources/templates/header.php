<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHPFOX CPR</title>
    <link rel="stylesheet" type="text/css" href="<?php echo PHPFOX_CPR_BASEURL.'css/responsive.css';?>"></link>
    <link rel="stylesheet" type="text/css" href="<?php echo PHPFOX_CPR_BASEURL.'css/jquery-ui.css" rel="stylesheet"';?>"></link>
    <script type="text/javascript">
        var aSvars = new Array(); 
        aSvars['sFoxRoot']="<?php echo $variables['sFoxRoot'];?>";
    </script>
    <script type="text/javascript" src="<?php echo PHPFOX_CPR_BASEURL.'/js/jquery1_11_3.js';?>"></script>
    <script type="text/javascript" src="<?php echo PHPFOX_CPR_BASEURL.'/js/jquery-ui.js';?>"></script>
    <script type="text/javascript" src="<?php echo PHPFOX_CPR_BASEURL.'/js/fox_cpr.js';?>"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

 
<body class="body">
<div id="container">
  <div id="top" class="header">
    <div class="logo">
        <form style="display: inline" action="<?php echo PHPFOX_CPR_BASEURL;?>index.php?page=home" method="get">    
            <button class="form_button">
                <img src="<?php echo PHPFOX_CPR_BASEURL ?>img/layout/wolfandfox2.png" height="64" width="64" alt="Wolf and Fox Logo"/><br /><?php echo $variables['lang']['MENU_HOME'];?>
            </button>
        </form>    
    </div>
    <div class="title"><img src="<?php echo PHPFOX_CPR_BASEURL ?>/img/layout/foodstorage.png" height="75" width="300" alt="phpfoxCPR"/></div>
    <?php if(!isset($_SESSION['user_id']) ||(isset($_SESSION['user_id']) && !$_SESSION['user_id'])) { ?>
    <div class="login">
        
 <!-- HTML --> 
      <div id="dialog-1" title="Please Login">        
	<form action="" id="login" method="post">
	<input type="hidden" name="auth_action" value="login" />
	<div class="table-left">
	  <?php echo $variables['lang']['MENU_EMAIL'];?>
	</div>
	<div class="table-right">
	  <input class="login_input" type="text" name="username" />
	</div>
	<div class="table-left">
	  <?php echo $variables['lang']['MENU_PASSWORD'];?> 
	</div>
	<div class="table-right">
	  <input class="login_input" type="password" name="password" />
	</div>
<!--	<input id="loginButton" class="form_button" type="submit" value="<?php echo $variables['lang']['MENU_LOGIN'];?>" /> -->
	</form> 
          
      </div>
      <button class="logout" id="opener"><?php echo $variables['lang']['MENU_LOGIN'];?></button>        
        
    </div>
    <?php } else { ?>
    <div class="logout">
<!--	<form action="" method="post">
	<input type="hidden" name="auth_action" value="logout" />
        <img src="<?php echo $_SESSION['image_path'] ?>" style="display: block;margin-left:auto;margin-right:auto;" />
	<div id="nameblock"><?php echo $_SESSION['full_name'] ?></div>
	<input id="logoutButton" class="form_button" type="submit" value="<?php echo $variables['lang']['MENU_LOGOUT'];?>" />
	</form> -->
        <form action="" method="post">
            <input type="hidden" name="auth_action" value="logout" />
            <button class="form_button">
                <img src="<?php echo $_SESSION['image_path'] ?>" style="display: block;margin-left:auto;margin-right:auto;" />
                <div id="nameblock"><?php echo $_SESSION['full_name'] ?></div>
                <?php echo $variables['lang']['MENU_LOGOUT'];?>
            </button>
        </form>    

    </div>

<?php } ?>

    <div class="clear"></div>
 </div>