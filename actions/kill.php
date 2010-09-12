<?php
/**
 * Searches for all objects of type widget.
 * Checks if their views are valid.
 * Removes them if not.
 */

// sometimes these entities are disable?
global $ENTITY_SHOW_HIDDEN_OVERRIDE;
$ENTITY_SHOW_HIDDEN_OVERRIDE = TRUE;

$result = TRUE;
$limit = 100;
$offset = 0;
$handler_view_cache = array();
$removed = 0;
$processed = 0;

$widgets = kill_dead_widgets_get_dead_widgets($limit);

while (is_array($widgets) && count($widgets)) {
	foreach ($widgets as $widget_guid) {
		$widget = get_entity($widget_guid->entity_guid);

		// previous versions of elgg used ElggPlugin.
		if (!$widget || !($widget instanceof ElggWidget || $widget instanceof ElggPlugin)) {
			continue;
		}

		$processed++;

		$handler = $widget->handler;
		$handler_view = "widgets/{$handler}/view";
		if (array_key_exists($handler_view, $handler_view_cache)) {
			$view_exists = $handler_view_cache[$handler_view];
		} else {
			$view_exists = elgg_view_exists($handler_view);
			$handler_view_cache[$handler_view] = $view_exists;
		}

		if (!$view_exists) {
			if ($widget_result = $widget->delete()) {
				$removed++;
			}

			$result = $result && $widget_result;
		}

		if ($removed >= 500) {
			break 2;
		}
	}

	$widgets = kill_dead_widgets_get_dead_widgets($limit);
}

if ($removed == 0 && $processed == 0) {
	system_message(elgg_echo('kdw:all_alive'));
} elseif ($result && $removed == $processed) {
	system_message(sprintf(elgg_echo('kdw:success'), $removed));
} elseif ($removed != $processed) {
	system_message(sprintf(elgg_echo('kdw:failure'), $removed, $processed));
}

forward(REFERER);