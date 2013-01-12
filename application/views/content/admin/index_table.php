<?
    /* Generate a table for the admin index page */
    // Clear any previous table data
    $this->table->clear();
    
    // Set header row
    $this->table->set_heading(
            "User ID",
            "First Name",
            "Last Name",
            "Email",
            "Security Level",
            "Edit User");
    
    // Build individual rows
    foreach($table_data->result() as $row){

        $this->table->add_row(
                $row->user_id,
                $row->first_name,
                $row->last_name,
                $row->email,
                // Humanize the security levels
                implode(', ', $this->authentication->security_to_string(
                        $row->security_level)),
                anchor(site_url("admin/edit_user/$row->user_id"), "Edit"));
    }
    
?>

<?= $this->table->generate() ?>