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
                        $default_values[USERS_FIRST_NAME]))));
    $this->table->add_row(
            form_label("Last Name:", USERS_LAST_NAME),
            form_input(array(
                "name"  => USERS_LAST_NAME,
                "id"    => USERS_LAST_NAME,
                "value" => set_value(USERS_LAST_NAME, 
                        $default_values[USERS_LAST_NAME]))));
    $this->table->add_row(
            form_label("Email:", USERS_EMAIL),
            form_input(array(
                'name'  => USERS_EMAIL,
                'id'    => USERS_EMAIL,
                "value" => set_value(USERS_EMAIL, 
                        $default_values[USERS_EMAIL]))));
    $this->table->add_row(
            form_label("Password:", USERS_PASSWORD),
            form_input(array(
                'name'  => USERS_PASSWORD,
                'id'    => USERS_PASSWORD,
                "value" => set_value(USERS_PASSWORD, 
                        $default_values[USERS_PASSWORD]))));
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
        echo "$name $zone_value";
        $this->table->add_row(        
            form_label($name, $name),
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
                "data"      => form_submit("submit", "Add User")
            ));

?>



<?= form_open(site_url("admin/new_user")) ?>
<?= $this->table->generate()?>

<input type='checkbox' name='admin' value="4" checked="FALSE">

<?= form_close() ?>