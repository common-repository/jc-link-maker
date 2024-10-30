<style type="text/css">
label{width:168px;float:left;}
</style>
<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2><?php echo (isset($editLinks))?'Edit':'Add';?> Links</h2>
<br/>
<form method="post" action="">
    <?php
        wp_nonce_field('cl_links', 'cl_links_nonce');
    ?>

<?php
if (isset($editLinks)) {

    $link = $links[$editLinks]['link'];
    $linkword = $links[$editLinks]['linkword'];
    $target = $links[$editLinks]['target'];
    $class = $links[$editLinks]['class'];
    $casesensitive = $links[$editLinks]['casesensitive'];
} else {
    $link = '';
    $linkword = '';
    $target = '';
    $class = '';
    $casesensitive = '';
}
?>
<label>Link:</label> <input name="link" type="text" id="link" value="<?php echo $link; ?>" />[eg: http://wordpress.org]<br/><br/>
<label>Text to Link:</label> <input name="linkword" type="text" id="linkword" value="<?php echo $linkword; ?>" />[static word eg; wordpress]<br/><br/>
<label>Target:</label> <input name="target" type="text" id="target" value="<?php echo $target; ?>" />[Target attribute in link;eg: _blank / _self / _parent]<br/><br/>
<label>Class:</label> <input name="class" type="text" id="class" value="<?php echo $class; ?>" />[class attribute for css or styling]<br/><br/>
<label>Case Sensitive:</label> 
<select name="casesensitive" id="casesensitive">
    <option value="no" <?php if($casesensitive == 'no')echo 'selected="selected"'; ?>>No</option>
    <option value="yes" <?php if($casesensitive == 'yes')echo 'selected="selected"'; ?>>Yes</option>
</select><br/><br/>
<?php
if (isset($editLinks)){
    echo "<input type='hidden' name='id' id='id' value='{$editLinks}' />";
    submit_button('Update', 'primary', 'edit', false,array('class'=>'button button-primary button-large'));
} else {
    submit_button('Add', 'primary', 'submit', false,array('class'=>'button button-primary button-large'));
}
?>
    </form>
    
   <br/>
<br/>
