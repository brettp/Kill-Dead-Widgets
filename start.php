<?php
/**
 * Removes all dead widget objects.
 */

register_elgg_event_handler('init', 'system', 'kill_dead_widgets_init');

/**
 * Init the plugin
 */
function kill_dead_widgets_init() {
	global $CONFIG;
	$action_path = dirname(__FILE__);

	// the only action we need.
	register_action('kill_dead_widgets/kill', FALSE, $action_path . '/actions/kill.php', TRUE);
}

/**
 * Returns the GUIDs of dead widgets.
 *
 * @param unknown_type $limit
 * @param unknown_type $offset
 * @param unknown_type $count
 */
function kill_dead_widgets_get_dead_widgets($limit = 10, $count=FALSE) {
	global $CONFIG;

	$handlers = array_keys($CONFIG->widgets->handlers);
	$handlers_quoted = array();
	foreach ($handlers as $handler) {
		$handlers_quotes[] = "'$handler'";
	}
	$handlers_str = implode(',', $handlers_quotes);

	$widget_subtype_id = get_subtype_id('object', 'widget');

	if ($count) {
		$sql = "SELECT COUNT(ps.entity_guid) as count FROM {$CONFIG->dbprefix}private_settings ps, {$CONFIG->dbprefix}entities e
		WHERE ps.name = 'handler' AND ps.value NOT IN ($handlers_str)
		AND e.subtype = $widget_subtype_id
		AND ps.entity_guid = e.guid";
		if ($r = get_data($sql)) {
			return (int) $r[0]->count;
		} else {
			return 0;
		}
	} else {
		$sql = "SELECT ps.entity_guid FROM {$CONFIG->dbprefix}private_settings ps, {$CONFIG->dbprefix}entities e
		WHERE ps.name = 'handler' AND ps.value NOT IN ($handlers_str)
		AND e.subtype = $widget_subtype_id
		AND ps.entity_guid = e.guid
		LIMIT $limit";

		return get_data($sql);
	}
}