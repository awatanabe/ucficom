Edit User
<br>
<?= anchor("admin/index", "Return to admin page") ?>
<br>
<?= $edit_form ?>
<br>
<?= button("admin/deactivate_user/$user_id", "Delete User");