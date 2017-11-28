<?php
require_once('../../config.php');
require_once('swagger_index_form.php');

global $DB, $USER, $CFG, $COURSE;
if (!($USER->id)) {
    redirect($CFG->wwwroot);
}

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('sandard');
$PAGE->set_title('Swagger UI  Settings');
$PAGE->set_heading('Swagger UI  Settings');
?>
<?php
echo $OUTPUT->header();

//$url = $CFG->wwwroot.'/local/lingk';
$url = $CFG->wwwroot.'/local/lingk/get_model.php';

$mform = new swagger_index_form($url);
    $mform->display();

echo $OUTPUT->footer();
?>

