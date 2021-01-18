<ul class="last_post_link nav nav-stacked">
	<?php
    foreach ($this->aboutLists['lists'] as $key => $value) {
        $cls = '';
        $icon = '';
        if( $value['id'] == $this->data['id'] ) {
            $cls = 'active-submenu';
            $icon = '<i class="fa fa-arrow-circle-right fa-fw" style="color:#8b0000;"></i>';
        }
        echo '<li class="nav-item '.$cls.'">
                <a href="'.$value['url'].'" class="nav-link text-muted">'.$icon.$value["name"].'</a>
              </li>';
    }
    ?>
</ul>