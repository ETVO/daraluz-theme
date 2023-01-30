<?php

/**
 * Customizer controls and options
 * 
 * @package WordPress
 */

use Kirki\Util\Helper;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Do not proceed if Kirki does not exist.
if (!class_exists('Kirki')) {
    return;
}

Kirki::add_config(
    'theme_options_config',
    [
        'option_type' => 'theme_mod',
        'capability'  => 'manage_options',
    ]
);

/**
 * Add a panel
 */
$panel_id = 'theme_options';
new \Kirki\Panel(
    $panel_id,
    [
        'priority'    => 10,
        'title'       => __('Opções do Tema'),
    ]
);

$sections = [
    'home' => 'Home',
];

$section_title_class = 'customize-section-title';

/**
 * Add all sections
 */
foreach ($sections as $section_id => $title) {
    $section_args = [
        'title' => $title,
        'panel' => $panel_id
    ];

    new \Kirki\Section(
        $section_id,
        $section_args
    );
}

/** ----- Home ----- */

$section = 'home';

new \Kirki\Field\Repeater(
    [
        'settings'    => 'cta_slides',
        'label'       => __('Slides'),
        'section'     => $section,
        'button_label' => esc_html__('Adicionar novo'),
        'row_label' => [
            'type'  => 'value',
            'value' => __('Slide'),
        ],
        'fields'      => [
            'id' => [
                'type' => 'number',
                'label' => __('ID'),
                'description' => __('ID do post da seção'),
            ]
        ],
    ]
);