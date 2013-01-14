<div id="message" class="<?= $type?>">
    <div class="grids">
        <?= empty_grid(1) ?>
        <div class="grid-14">
            <div id="message_title"><?= strtoupper($title) ?></div> 
            <?= $content ?>
        </div>    
        <?= empty_grid(1) ?>
    </div>
</div>