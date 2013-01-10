<?
$this->table->add_row(
        label(USERS_EMAIL, "Email:"),
        form_input(USERS_EMAIL) );
?>

<?= form_open(site_url("admin/new_user")) ?>
<?= $this->table-generate() ?>

<?= form_close() ?>