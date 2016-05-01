<div class="clear"></div>
<div class="footer">
	<div class="languages">
		<ul class="footer_menu">
                        <?php
                        foreach($variables['languages'] as $key=>$value)
                        {
                            echo '<li><a href="'.PHPFOX_CPR_BASEURL.'index.php?lang='.$key.'&page='.$variables['current_page'].'"><img src="'.$value['img'].'" /><br />'.$value['label'].'</a></li>';
                        }
                        ?>
                </ul>
	</div>
    <div class="clear"></div>
</div>
</div><!--Close container division-->

</body>
</html>