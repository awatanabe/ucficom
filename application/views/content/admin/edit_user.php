<?= anchor("admin/index", "Return to admin page") ?>
<h2>Edit User</h2>
<div class="grids">
    <?= empty_grid(1) ?>
    <div class="grid-5">
        <p>
            Update a user's information. You may reset a user's password with the reset password 
            button, which will email the user will a new, random password (feature to be implemented).
            You may also deactivate this user's account.
        </p>
        <div class="center_align">
        <?= button("admin/deactivate_user/".$default_values[USERS_USER_ID],
                        "Deactivate User", "critical_button") ?>        
        </div>
    </div>
    <?= empty_grid(1) ?>
    <div class="grid-9">
        <?= $edit_form ?>
    </div>
</div>
