<?
    // Generate table with table_form library
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
    foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
        $this->table_form->checkbox_input(ucfirst("$name:"), $name, $zone_value,
         set_checkbox($name, $zone_value));
    }    
    $this->table_form->submit_cancel("Add User", ADMIN_HOME);
    
?>

<?= $this->table_form->generate(current_url()) ?>