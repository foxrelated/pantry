<?php
 
function renderLayoutWithContentFile($contentFile, $variables = array())
{
	$contentFileFullPath = TEMPLATES_PATH . "/" . $contentFile;
 
    
	// making sure passed in variables are in scope of the template
	// each key in the $variables array will become a variable
	if (count($variables) > 0) 
	{
		foreach ($variables as $key => $value) 
		{
			if (strlen($key) > 0) 
			{
				${$key} = $value;
			}
		}
	}
 
	require_once(TEMPLATES_PATH . "/header.php");
	echo '<div class="main_wrapper">';
 
	echo "<div class=\"framecontent\" id=\"leftnav\">\n";
		require_once(TEMPLATES_PATH . "/leftPanel.php");
	echo"\t</div>\n";

	echo "<div class=\"maincontent\" id=\"content\">\n";

	echo '<div class="messages_holder"><div class="messages">&nbsp; ';
	if(isset($variables['messages']))
	{
		echo $variables['messages'];
	}
	echo " </div></div>";

 
	if (file_exists($contentFileFullPath)) 
	{
		require_once($contentFileFullPath);
	} 
	else 
	{
		/*
		If the file isn't found the error can be handled in lots of ways.
		In this case we will just include an error template.
		*/
		require_once(TEMPLATES_PATH . "/error.php");
	}
 
	// close maincontent div
	echo "\t</div>\n";
	// close main wrapper
	echo '</div>'; 

	require_once(TEMPLATES_PATH . "/footer.php");
}
?>