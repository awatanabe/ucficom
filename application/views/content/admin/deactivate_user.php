<?

    $this->table_form->clear();
    $this->table_form->add_input_row("First Name:", USERS_FIRST_NAME, html_escape($first_name));
    $this->table_form->add_input_row("Last Name:", USERS_LAST_NAME, html_escape($last_name));
    $this->table_form->add_input_row("Email:", USERS_EMAIL, html_escape($email));    
    $this->table_form->submit_cancel("Deactivate User", "admin/edit_user/$user_id", BUTTON_CRITICAL);
?>

<?= anchor("admin/edit_user/$user_id", "Return to editing user") ?>
<h2>Deactivate User</h2> 
<br>
<div class="grids">
    <?= empty_grid(1) ?>
    <div class="grid-5">
        <p>
            Deactivate this user from the system. You may reactivate this user at a later time.
        </p>
    </div>
    <div class="grid-10">    
        <?= $this->table_form->generate(current_url()) ?>
    </div>
</div>