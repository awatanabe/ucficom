<?

    // Create table
    $this->table->clear();
    $this->table->set_heading(array(
                "colspan"   =>  2,
                "data"      => '')); 
    $this->table->add_row(
            "First Name:",
            html_escape($first_name));
    $this->table->add_row(
            "Last Name:",
            html_escape($last_name));
    $this->table->add_row(
            "Email:",
            html_escape($email));
    $this->table->add_row(array(
        "colspan" =>    2,
        "data" =>       form_submit("submit", "Deactivate").  button("admin/edit_user/$user_id", "Cancel")));

?>

Deactivate User
<br>
Are you sure that you want to delete the following user?
<?= form_open(current_url()) ?>
<?= $this->table->generate() ?>
<?= form_close() ?>