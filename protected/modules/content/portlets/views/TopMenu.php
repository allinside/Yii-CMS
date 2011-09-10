<ul>
	<?php foreach ($sections as $section): ?>
        <?php
        $url   = $this->url($section->href);
        $class = $url == $_SERVER['REQUEST_URI'] ? 'active' : '';
        ?>
		 <li class="<?php echo $class; ?>">
            <a href="<?php echo $url; ?>"><?php echo $section->title; ?></a>

		 	<?php if ($section->childs): ?>
		 		<ul class="sub_menu">
			 		<?php foreach ($section->childs as $child): ?>
						<?php if (!$child->is_visible) continue; ?>

			 			<li>
                            <a href="<?php echo $this->url($child->href); ?>"><?php echo $child->title; ?></a>
			 			</li>
			 		<?php endforeach ?>
		 		</ul>
		 	<?php endif ?>

		 </li>
	<?php endforeach ?>
</ul>


