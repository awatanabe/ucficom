<?
/* Generate the table with inputs */
// Eliminate header row

// Eliminate the table headers
$this->table->set_template(array("table_open" => "<table>"));

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
            "id"    => USERS_FIRST_NAME)));
$this->table->add_row(
        form_label("Last Name:", USERS_LAST_NAME),
        form_input(array(
            "name"  => USERS_LAST_NAME,
            "id"    => USERS_LAST_NAME)));
$this->table->add_row(
        form_label("Email:", USERS_EMAIL),
        form_input(array(
            'name'  => USERS_EMAIL,
            'id'    => USERS_EMAIL)));
$this->table->add_row(
        form_label("Password:", USERS_PASSWORD),
        form_input(array(
            'name'  => USERS_PASSWORD,
            'id'    => USERS_PASSWORD)));
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
$this->table->add_row(
        form_label("Admin", "admin"),
        form_checkbox(array(
            "name"  => "admin",
            "id"    => "admin",
            "value" => ADMIN,
            "checked" =>    FALSE
        )));
$this->table->add_row(
        form_label("Manage", "manage"),
        form_checkbox(array(
            "name"  => "manage",
            "id"    => "manage",
            "value" => MANAGE,
            "checked" =>    FALSE
        )));
$this->table->add_row(
        array(
            "colspan"   => 2,
            "data"      => form_submit("submit", "Add User")
        ));

?>

<?= form_open(site_url("admin/new_user")) ?>
<?= $this->table->generate()?>

<?= form_close() ?>