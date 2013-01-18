<?
    /**
     * Creates a table with user's information and a button to deactivate
     */
    $this->table_form->clear();
    $this->table_form->add_input_row("First Name:", USERS_FIRST_NAME, html_escape($first_name));
    $this->table_form->add_input_row("Last Name:", USERS_LAST_NAME, html_escape($last_name));
    $this->table_form->add_input_row("Email:", USERS_EMAIL, html_escape($email));    
    $this->table_form->submit_cancel("Deactivate User", "admin/edit_user/$user_id", BUTTON_CRITICAL);
?>