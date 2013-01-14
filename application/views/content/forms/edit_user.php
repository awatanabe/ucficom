<?

/* Generate the table with inputs */
// Eliminate header row


    $this->table->set_heading(
            array(
                "colspan"   =>  2,
                "data"      => ''
            )
            ); 
    $this->table->add_row(
            form_label("First Name:", USERS_FIRST_NAME),
            form_input(array(
                "name"  => USERS_FIRST_NAME,
                "id"    => USERS_FIRST_NAME,
                "value" => set_value(USERS_FIRST_NAME, 
                html_escape($default_values[USERS_FIRST_NAME])))));
    $this->table->add_row(
            form_label("Last Name:", USERS_LAST_NAME),
            form_input(array(
                "name"  => USERS_LAST_NAME,
                "id"    => USERS_LAST_NAME,
                "value" => set_value(USERS_LAST_NAME, 
                html_escape($default_values[USERS_LAST_NAME])))));
    $this->table->add_row(
            form_label("Email:", USERS_EMAIL),
            form_input(array(
                'name'  => USERS_EMAIL,
                'id'    => USERS_EMAIL,
                "value" => set_value(USERS_EMAIL, 
                html_escape($default_values[USERS_EMAIL])))));
    $this->table->add_row(
            "Password:",
             anchor("admin/reset_password/".$default_values["user_id"], 
                     "Reset Password"));
    $this->table->add_row(
            array(
                "data"      => "Security Levels",
                "colspan"   => 2
            ));

    // Build input for each zone
    foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
        $this->table->add_row(        
            form_label(ucfirst("$name:"), $name),
            form_checkbox(
                    $name,
                    $zone_value, 
                    set_checkbox($name, $zone_value, $default_values[$name]),
                    "id='$name'"));
    }
    // Add submit button
    $this->table->add_row(
            array(
                "colspan"   => 2,
                "data"      => form_submit("submit", "Update")
            ));

?>

<?= form_open(current_url()) ?>
<?= $this->table->generate()?>


<?= form_close() ?>