<?php
defined('MOODLE_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportinfectedfiles',
    get_string('pluginname', 'local_report'),
    "$CFG->wwwroot/local/report/view.php"));

$settings = null;