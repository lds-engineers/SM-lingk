<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once(dirname(__FILE__) . '/../../config.php');
 
class swagger_index_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $DB,$CFG;
        
        // $attr = 'style="height:400px"';
        $attr2 = 'style="width:400px" readonly';
        $url = $CFG->wwwroot;
        $mform = $this->_form; // Don't forget the underscore! 
 



        $mform->addElement('text', 'host', get_string('host','local_lingk'),$attr2); 
        $mform->setType('host', 'this the host name for the swagger json file ');         
        $mform->setDefault('host', $url);     
        $mform->addElement('static', 'description_host', '',get_string('description_host', 'local_lingk'));
     
        $basepath = '/local/lingk/mvcswagger';
        $mform->addElement('text', 'basepath', get_string('basepath','local_lingk'),$attr2); 
        $mform->setType('basepath', PARAM_NOTAGS);    
        $mform->setDefault('basepath', $basepath); 
        $mform->addElement('static', 'description_basepath', '',get_string('description_basepath', 'local_lingk'));

            $gettablename = $DB->get_tables();
            $arr = array();
            foreach ($gettablename as $gettablenamedata) {
                    $arr[$gettablenamedata] = $gettablenamedata; 
            }

        $select =$mform->addElement('select', 'table', get_string('table','local_lingk'),$arr,'style="width:400px;height:260px"'); 
        $mform->addRule('table', get_string('table','local_lingk'), 'required', null, '');
        $select->setMultiple(true);
       $mform->addElement('static', 'description_table', '',get_string('description_table', 'local_lingk'));
  
       $mform->addElement('submit', 'submit', get_string('submit','local_lingk'));
       $mform->addElement('html', '<a class="btn btn-primary" href="'.$CFG->wwwroot.'/local/lingk/swagger/swagger-editor" target="_blank">Swagger Editor</a>');
       
   
       
       $mform->addElement('html',get_string('settings_title','local_lingk'));

        
  }
   
}
