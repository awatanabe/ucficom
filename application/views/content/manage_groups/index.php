<h2>GROUPS HOME PAGE</h2>
<br>
<?
    /* Generate a table for the admin index page */
    // Clear any previous table data
    $this->table->clear();
    
    // Set header row
    $this->table->set_heading(
            "Group ID",
            "Name",
            "Email",
            "Type",
            "Edit");
    
    // Build individual rows
    foreach($table_data->result() as $row){

        $this->table->add_row(
                $row->group_id,
                $row->name,
                $row->email,
                $row->type,
                anchor(site_url("manage_groups/edit/$row->group_id"), "Edit"));
    }
    
?>

<?= $this->table->generate() ?>