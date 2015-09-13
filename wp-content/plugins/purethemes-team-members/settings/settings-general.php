<?php

global $PMSF_settings;

// General Settings section
$PMSF_settings[] = array(
    'section_id' => 'general',
    'section_title' => 'General Settings',
    'section_description' => 'Common settings for all members typography.',
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'title-text',
            'title' => 'Text',
            'desc' => 'Title of the Member Area .',
            'type' => 'text',
            'std' => 'Our Team Members'
        ),
		array(
            'id' => 'border-color',
            'title' => 'Border Colour',
            'desc' => 'Single Member Border Colour.',
            'type' => 'color',
            'std' => '#6BDA9A'
        ),
        array(
            'id' => 'color',
            'title' => 'Non Hover Colour',
            'desc' => 'Select colour when a member not hovered.',
            'type' => 'color',
            'std' => '#000000'
        ),        	
		array(
            'id' => 'hover-color',
            'title' => 'Hover Colour',
            'desc' => 'Select colour when a member hovered.',
            'type' => 'color',
            'std' => '#F2CA27'
        ),
	    array(
            'id' => 'custom-css',
            'title' => 'Custom CSS',
            'desc' => 'Custom css coding area. Use !important if needed',
            'type' => 'textarea',
            'std' => ''
        ),
    )
);


?>