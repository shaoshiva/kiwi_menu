<ul class="<?= $level ? 'dropdown' : 'left' ?>">
	<?php
	foreach ($items as $item) {
		// Is the item published ?
		if (!$item->driver()->published()) {
			continue;
		}

		// Has dropdown ?
		$has_dropdown = ($level < $depth && count($item->children));

		// CSS classes
		$classes = array(
            'lvl'.$level,
            $item->driver()->cssClass(),
            $item->driver()->active() ? 'active' : '',
            $has_dropdown ? 'has-dropdown' : '',
        );
		?>
        <li class="divider"></li>
		<li class="<?= implode(' ', array_filter($classes)) ?>">
            <?= $item->driver()->display() ?>
			<?php
			if ($has_dropdown) {
				echo \View::forge('kiwi_menu::front/template/horizontal/layout-level', array(
					'items'	=> $item->children,
					'level'	=> $level + 1,
					'depth'	=> $depth,
				));
			}
			?>
		</li>
		<?php
	}
	?>
</ul>
