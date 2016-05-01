<?php

?>
<div class="innertube">
	<div class="mainContent">
	<h2>Error</h2>
 
<?php
 
if(isset($variables['errors']))
{
	echo "<ul>";

	foreach($variables['errors'] as $sError)
	{
		echo '<li>'.$sError . '</li>';
	}

	echo "</ul>
	</div>
</div>";
}
 
?>
