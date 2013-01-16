<?

    $this->table_form->text_input("Email:", USERS_EMAIL, 
            html_escape(set_value(USERS_EMAIL)));
    $this->table_form->password_input("Password", USERS_PASSWORD);
    $this->table_form->submit("Log In");


?>
<?= $this->table_form->generate(current_url()) ?>