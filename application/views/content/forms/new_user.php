<?
/*

*/
$this->table->set_heading(null); 
$this->table->add_row(
        "<label for='".USERS_EMAIL."'>Email:</label>",
        form_input(array(
            'name' => USERS_EMAIL,
            'id' => USERS_EMAIL)));

?>

<?= form_open(site_url("admin/new_user")) ?>
<?= $this->table->generate()?>

<?= form_close() ?>