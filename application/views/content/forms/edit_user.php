<?
    $this->table_form->clear();
    $this->table_form->text_input("First Name:", USERS_FIRST_NAME, $default_values[USERS_FIRST_NAME]);
    $this->table_form->text_input("Last Name:", USERS_LAST_NAME, $default_values[USERS_LAST_NAME]);
    $this->table_form->text_input("Email:", USERS_EMAIL, $default_values[USERS_EMAIL]); 
    $this->table_form->add_input_row("Password:", USERS_PASSWORD, 
     button("admin/reset_password/".$default_values[USERS_USER_ID], "Reset Password", BUTTON_CRITICAL));
    $this->table_form->add_line("Security Levels");
    foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
        $this->table_form->checkbox_input(ucfirst("$name:"), $name, $zone_value, 
                $default_values[$name]);
    }    
    $this->table_form->submit_cancel("Update User", ADMIN_HOME);
    
?>
<?= $this->table_form->generate(current_url()) ?>