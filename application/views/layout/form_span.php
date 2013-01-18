<div class="grids">
    <?= empty_grid(1) ?>
    <div class='grid-4 <?= $secondary_class?>' <?= $attributes?>>
        <p>
            <?= $secondary_data ?>
        </p>
    </div>
    <?= empty_grid(1) ?>
    <div class='grid-10 <?= $primary_class?>' <?= $attributes ?>>
        <?= $primary_data ?>
    </div>
</div>