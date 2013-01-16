<div class="left_align">
    <?= anchor(ADMIN_HOME, "Return to admin page") ?>
</div>
<h2>Add New User</h2>
<div class="grids">
    <?= empty_grid(1) ?>
    <div class="grid-5">
        This will add a new user to the FiCom user system. Please note that email address must be unique to the system.
        Once a user is added, the user's information will never be removed from the system. Contact a sysadmin if you need
        to reactivate a deactivated user.
    </div>
    <div class="grid-8 left_align">
        <?= $new_user_form ?>
    </div>
    <?= empty_grid(2) ?>
</div<
