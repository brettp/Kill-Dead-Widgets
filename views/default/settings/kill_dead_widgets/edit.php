<?php
/**
 * Settings with a clickable link to kill the widgets
 */

$url = $vars['url'] . 'action/kill_dead_widgets/kill';
$url = elgg_add_action_tokens_to_url($url);
$widgets_count = kill_dead_widgets_get_dead_widgets(0, TRUE);

?>
<p>
<?php echo elgg_echo('kdw:intro'); ?>
</p>

<?php
if ($widgets_count == 0) {
	// keep the link for the js to hide the save button.
?>
	<br />
	<p>
	<?php echo elgg_echo("kdw:all_alive"); ?>
	<a id="kdw_link_o_death"></a>
	</p>
<?php
} else {
?>
	<br />
	<p>
<?php
	echo sprintf(elgg_echo('kdw:widget_count'), $widgets_count);

	if ($widgets_count > 500) {
		echo ' ' . elgg_echo('kdw:many_widgets');
	}
?>
	</p>

	<br />
	<p>
	<a id="kdw_link_o_death" href="<?php echo $url; ?>"><?php echo elgg_echo('kdw:link')?></a>
	</p>
<?php
}
?>

<script type="text/javascript">
// dirty way to hide the save button.
$(function() {
	$('#kdw_link_o_death').parent().parent().find('input.submit_button[type=submit][value=Save]').hide();
});
</script>