<?php
if (empty($items)) {
	return ;
}
?>
<nav class="top-bar">
    <section class="top-bar-section">
        <?= \View::forge('kiwi_menu::front/template/horizontal/layout-level', array(
            'items'	=> $items,
            'level'	=> 0,
            'depth'	=> !empty($depth) ? $depth : 3,
        ), false);
        ?>
    </section>
</nav>
<?php
?>
