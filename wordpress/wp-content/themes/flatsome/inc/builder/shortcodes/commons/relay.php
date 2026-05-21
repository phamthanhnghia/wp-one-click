<?php

return array(
	'type'       => 'group',
	'heading'    => 'Pagination',
	'conditions' => 'type != "slider" && type != "slider-full"',
	'options'    => array(
		'relay'                      => array(
			'type'    => 'select',
			'heading' => 'Type',
			'default' => '',
			'options' => array(
				''           => 'None',
				'pagination' => 'Pagination links',
				'load-more'  => 'Load more',
				'prev-next'  => 'Previous / Next',
			),
		),
		'relay_control_result_count' => array(
			'type'       => 'checkbox',
			'heading'    => 'Result count',
			'conditions' => 'relay == "load-more"',
			'default'    => 'true',
		),
		'relay_control_position'     => array(
			'type'       => 'select',
			'heading'    => 'Position',
			'conditions' => 'relay',
			'default'    => 'bottom',
			'options'    => array(
				'top'        => 'Top',
				'bottom'     => 'Bottom',
				'top-bottom' => 'Top & bottom',
			),
		),
		'relay_control_align'        => array(
			'type'       => 'radio-buttons',
			'heading'    => 'Align',
			'conditions' => 'relay',
			'default'    => 'center',
			'options'    => require __DIR__ . '/../values/align-radios.php',
		),
		'relay_id'                   => array(
			'type'       => 'textfield',
			'heading'    => 'ID',
			'conditions' => 'relay',
			'default'    => '',
		),
		'relay_class'                => array(
			'type'       => 'textfield',
			'heading'    => 'Class',
			'conditions' => 'relay',
			'default'    => '',
		),
	),
);
