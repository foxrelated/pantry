
<div class="current_language">
    <?php echo '<div>'.$variables['lang']['CURRENT_LANGUAGE'].'</div><div class="lang_icon"><img src='.$variables['current_language']['img'].' /></div><div class="bold_18">'.$variables['current_language']['label'].'</div><div class="clear"></div>';  ?>
</div>
<div class="clear"></div>
<?php 
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) 
{
?>

    <div class="categories">
        <div class="cat_items"><a href="<?php echo PHPFOX_CPR_BASEURL?>index.php?page=add"><button type="submit" class="form_button">Add an Item</button></a></div>
        <div class="cat_items"><a href="<?php echo PHPFOX_CPR_BASEURL?>index.php?page=browse"><button type="submit" class="form_button">List Items</button></a></div>
        <div class="cat_items"><a href="<?php echo PHPFOX_CPR_BASEURL?>index.php?page=sample"><button type="submit" class="form_button"><?php echo $variables['lang']['MENU_PLUGINS'];?></button></a></div>
    </div>


<?php
}
else
{
    echo $variables['lang']['MESSAGES_LOGIN_BEGIN'];
}
?>
    <div class="clear"></div>

 
