<?

/* Generate the table with inputs */
// Eliminate header row 
    
    $this->table->set_heading(
            array(
                "colspan"   =>  2,
                "data"      => '')); 
    $this->table->add_row(
            form_label("First Name:", USERS_FIRST_NAME),
            form_input(array(
                "name"  => USERS_FIRST_NAME,
                "id"    => USERS_FIRST_NAME,
                "value" => html_escape(set_value(USERS_FIRST_NAME)))));
    $this->table->add_row(
            form_label("Last Name:", USERS_LAST_NAME),
            form_input(array(
                "name"  => USERS_LAST_NAME,
                "id"    => USERS_LAST_NAME,
                "value" => html_escape(set_value(USERS_LAST_NAME)))));
    $this->table->add_row(
            form_label("Email:", USERS_EMAIL),
            form_input(array(
                'name'  => USERS_EMAIL,
                'id'    => USERS_EMAIL,
                "value" => html_escape(set_value(USERS_EMAIL)))));
    $this->table->add_row(
            form_label("Password:", USERS_PASSWORD),
            form_input(array(
                'name'  => USERS_PASSWORD,
                'id'    => USERS_PASSWORD,
                "value" => html_escape(set_value(USERS_PASSWORD)))));
    $this->table->add_row(
            array(
                "data"      => "Please record the password to give to the new user",
                "colspan"   => 2
            ));
    $this->table->add_row(
            array(
                "data"      => "Security Levels",
                "colspan"   => 2
            ));
    // Get the different internal security levels
    $INTERNAL_SECURITY_ZONES = unserialize(INTERNAL_SECURITY_ZONES);

    // Build input for each zone
    foreach($INTERNAL_SECURITY_ZONES as $name => $zone_value){
        $this->table->add_row(        
            form_label(ucfirst("$name:"), $name),
            form_checkbox(
                    $name,
                    $zone_value, 
                    set_checkbox($name, $zone_value),
                    "id='$name'"));
    }
    // Add submit button
    $this->table->add_row(
            array(
                "colspan"   => 2,
                "data"      => form_submit("submit", "Add User")
            ));

?>



<?= form_open(site_url("admin/new_user")) ?>
<?= $this->table->generate()?>

<?= form_close() ?>
<?
    $this->table_form->clear();
    $this->table_form->text_input("First Name:", USERS_FIRST_NAME, 
     html_escape(set_value(USERS_FIRST_NAME)));
    $this->table_form->text_input("Last Name:", USERS_LAST_NAME, 
     html_escape(set_value(USERS_LAST_NAME)));
    $this->table_form->text_input("Email:", USERS_EMAIL, 
     html_escape(set_value(USERS_EMAIL)));
    $this->table_form->text_input("Password:", USERS_PASSWORD, 
     html_escape(set_value(USERS_PASSWORD)));
    // Build input for each zone
    foreach($INTERNAL_SECURITY_ZONES as $name => $zone_value){
        $this->table_form->checkbox_input(ucfirst("$name:"), $name, $zone_value,
         set_checkbox($name, $zone_value));
    }    
    $this->table_form->submit("Add User", button(ADMIN_HOME, "Cancel"));
    
?>

<?= $this->table_form->generate(current_url()) ?>