<?

    // Create table
    $this->table->clear();
    $this->table->set_heading(array(
                "colspan"   =>  2,
                "data"      => '')); 
    $this->table->add_row(
        form_label("New Password", USERS_PASSWORD),
             form_input(USERS_PASSWORD, 
                     set_value(USERS_PASSWORD)));
    $this->table->add_row(array(
        "colspan" =>    2,
        "data" =>       form_submit("submit", "Reset Password").  button("admin/edit_user/$user_id", "Cancel")));

?>

Reset Password
<br>
Reset <?= html_escape($first_name)." ".html_escape($last_name) ?>'s password
<?= form_open(current_url()) ?>
<?= $this->table->generate() ?>
<?= form_close() ?>