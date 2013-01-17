<?
    // Create table
    $this->table_form->clear();
    $this->table_form->text_input("New Password", USERS_PASSWORD);
    $this->table_form->submit_cancel("Reset Password", "admin/edit_user/$user_id");

?>
<?= anchor("admin/edit_user/$user_id", "Return to editing user") ?>
<h2>Reset Password</h2> 
<br>
<div class="grids">
    <?= empty_grid(1) ?>
    <div class="grid-5">
        <p>
            Reset <?= html_escape($first_name)." ".html_escape($last_name) ?>'s password. Please 
            notity the user of the new password.
        </p>
    </div>
    <div class="grid-10">    
        <?= $this->table_form->generate(current_url()) ?>
    </div>
</div>