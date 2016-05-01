
<div class="innertube" id="menu_holder">
    <h1>Food Storage</h1>

<table style="border-collapse: collapse;">
    <tr>
<?php 
foreach($variables['aItems'][0] as $key => $value)
{
    switch ($key)
    {
        case 'item_id':
            break;
        
        case 'quantity':
            echo '<th style="width:75px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break;
        
        case 'name':
            echo '<th style="width:280px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break;
        
        case 'gf_flag':
            echo '<th style="width:36px;"><a href=/index.php?page=browse&sort_column='.$key.'><img src="/img/layout/gf.png"/></a></th>';
            break;
        
        case 'size':
            echo '<th style="width:100px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break;       
        
        case 'units':
            echo '<th style="width:60px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break; 
        
        case 'location':
            echo '<th style="width:100px;"><a href=/index.php?page=browse&sort_column=location,shelf >'.strtoupper($key).'</a></th>';
            break;   
        
        case 'shelf':
            echo '<th style="width:50px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break;   
        
        case 'use_by':
            echo '<th style="width:100px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper(str_replace('_',' ', $key)).'</a></th>';
            break;  
        
        case 'upc':
            echo '<th style="width:100px;"><a href=/index.php?page=browse&sort_column='.$key.'>'.strtoupper($key).'</a></th>';
            break;   
    }
    
    
   // echo $key=='item_id' || $key=='gf_flag'?'':'<th style="width:100px;">'.strtoupper($key).'</th>';        
}
?>
</tr>    
    
    
<?php
//var_dump($variables['aItems']);
foreach ($variables['aItems'] as $key => $aItem)
{
    echo '<tr id="row_'.$aItem['item_id'].'">';
    foreach($aItem as $key => $value)
    {
        echo $key=='item_id' || $key=='quantity' || $key=='gf_flag'?'':"<td>".$value."</td>";
        echo $key=='gf_flag'?'<td width=35px>'.$value.'</td>':'';
        echo $key=='quantity'?'<td><input class="spinner" id="'.$aItem['item_id'].'" name="quantity['.$aItem['item_id'].']" value="'.$aItem['quantity'].'"  size="2"   >'."</td>":'';
    }
//    echo '<td style="height"><a href="#" id="ei_'.$aItem['item_id'].'" class="ei"><div style="width:16px;height:50%;display:block;"><img src="/img/layout/application_edit.png"/></div></a><br /><a href="#" id="di_'.$aItem['item_id'].'" class="di"><div style="width:16px;height:50%;display:block;"><img src="/img/layout/delete_hover.gif"/></div></a></td>';
echo '<td class="tworow">'
    . '<div class="tworowout">'
        . '<a href="#" id="ei_'.$aItem['item_id'].'" class="ei">'
        . '<div style="height:50%;display:block;background:#9f9;padding-top:4px;">'
            . '<img class="centerimg" src="/img/layout/application_edit.png"/>'
        . '</div></a><a href="#" id="di_'.$aItem['item_id'].'" class="di">'
        . '<div style="height:50%;display:block;background:#f99;padding-top:6px;">'
            . '<img class="centerimg" src="/img/layout/delete_hover.gif"/>'
        . '</div></a>'
    . '</div>'
    . '</td>';
    echo '</tr>';
}


?>
    
    
    
</table>    
    
    <div id="bbb" style="height:104px;">xxx</div>    
</div>
