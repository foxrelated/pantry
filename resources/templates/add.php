
<div class="innertube" id="menu_holder">

<form action="" method="post">
    <input type="hidden" name="item_id" value="<?php echo $variables['aItem']['item_id']; ?>"/>
    <input type="hidden" name="addItem" value="<?php echo $variables['aItem']['item_id']>0?'edit':'add'; ?>" />
    <div>
    Item name:<br>
        <input type="text" name="name" value="<?php echo $variables['aItem']['name'] ?>" autocomplete="off" list='item_name'/>
        <datalist id="item_name">
        <?php        
          foreach($variables['names'] as $aName)
          {
              echo '<option value="'.$aName['name'].'"></option>';
          }
        ?>
        </datalist>
    </div>
    <div>
        <input type="checkbox" name="gf_flag" value="1" <?php echo empty($variables['aItem']['gf_flag'])?'':'checked="checked"' ?> />Gluten-free
    </div>
    <br />
  Size:<br>
  <input type="text" name="size" value="<?php echo $variables['aItem']['size'] ?>" autocomplete="off" list="item_size" /><br>
      <datalist id="item_size">
  <?php        
  foreach($variables['size'] as $aSize)
  {
      echo '<option value="'.$aSize['size'].'"></option>';
  }
?>
      </datalist>
  Unit:<br>
  <input type="text" name="units" value="<?php echo $variables['aItem']['units'] ?>" list="item_units" autocomplete="off" /><br>
      <datalist id="item_units">
<?php        
  foreach($variables['units'] as $aUnit)
  {
      echo '<option value="'.$aUnit['units'].'"></option>';
  }
?>
    </datalist>
  Quantity:<br>
  <input type="text" name="quantity" value="<?php echo $variables['aItem']['quantity'] ?>"/><br>
  Location:<br>
  <input type="text" name="location" value="<?php echo $variables['aItem']['location'] ?>"/><br>
  Shelf:<br>
  <input type="text" name="shelf" value="<?php echo $variables['aItem']['shelf'] ?>"/><br>
  Use by date:<br>
  <input type="text" id="datepicker" name="use_by" value="<?php echo $variables['aItem']['use_by'] ?>"/><br>
  UPC:<br>
  <input type="text" name="upc" value="<?php echo $variables['aItem']['upc'] ?>"/><br><br>

  <input type="submit" value="Submit" />
  <?php if($variables['aItem']['item_id']>0){ ?>
      <br />  <br />
      <input type="checkbox" name="duplicate" id="dup" /> Duplicate
      <br />
      <span>Note: checking the box above will cause a new record to be created with the above information.</span>
  <?php } else { ?>
      <input type="hidden" name="duplicate" id="dup"value="" />
  <?php } ?>
      
</form> 
    
    
    
    
    
    
</div>
