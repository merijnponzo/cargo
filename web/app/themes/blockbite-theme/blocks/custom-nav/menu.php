<?php

use Blockbite\Fields\siteFields;

$menu_name = 'main-menu';
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object($locations[$menu_name]);
$menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));
// use id's as key
$menuNested = array_combine(array_column($menuitems, 'ID'), $menuitems);
// create hierarchy 
foreach ($menuNested as $key => $item) {
    if ($item->menu_item_parent) {
        // create submenu array if not exists
        if (isset($menuNested[$item->menu_item_parent])) {
            if (!isset($menuNested[$item->menu_item_parent]->submenu)) {
                $menuNested[$item->menu_item_parent]->submenu = [];
            }
            if (isset($menuNested[$item->menu_item_parent]->submenu)) {
                // add subitem to it
                $menuNested[$item->menu_item_parent]->submenu[] = $item;
                // remove subitem from main array
            }
            unset($menuNested[$key]);
        }
    }
    // implode class array and overwrite
    if ($item->classes) {
        $item->classes = implode(' ', $item->classes);
    }
}
?>
<nav class="menu" x-on:resize.window="mobile = false, open = false" x-init="{open : false, mobile: false }" x-data="{ open: false , mobile: false}" :class="mobile ? 'open' : 'closed'">
    <ul>
        <?php foreach ($menuNested as $key => $item) : ?>
            <li>
                <?php if (isset($item->submenu)) : ?>
                    <a href="javascript:void(0)" @click="!open ? open = <?php echo $item->ID; ?> : open = false" class="<?php echo $item->classes; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="angle-down" viewBox="0 0 24 24" x-bind:class="(open === <?php echo $item->ID; ?>) ? 'open' : 'closed'">
                            <path d="M17,9.17a1,1,0,0,0-1.41,0L12,12.71,8.46,9.17a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42l4.24,4.24a1,1,0,0,0,1.42,0L17,10.59A1,1,0,0,0,17,9.17Z" />
                        </svg>
                        <span><?php echo $item->title ?></span>
                    </a>
                <?php else : ?>
                    <a href="<?php echo $item->url ?>" class="<?php echo $item->classes; ?>">
                        <?php echo $item->title ?>
                    </a>
                <?php endif   ?>
                <?php if (isset($item->submenu)) : ?>
                    <ol class="submenu--wrap " x-bind:class="(open === <?php echo $item->ID; ?>) ? 'open' : 'closed'" x-cloak>
                        <ul class="submenu">
                            <li class="submenu--closemobile">
                                <button @click="open = false"> ← Vorige</button>
                            </li>
                            <?php foreach ($item->submenu as $child) : ?>
                                <?php
                                // custom fields
                                $menu_desc = siteFields::menu_item('desc', $child);
                                $menu_svg = siteFields::menu_item('svg', $child);
                                ?>
                                <li>
                                    <a href="<?php echo $child->url ?>" class="<?php echo $item->classes; ?>">

                                        <span>
                                            <?php if ($menu_svg) : ?>
                                                <?php echo $menu_svg; ?>
                                            <?php endif ?>
                                            <h5><?php echo $child->title ?></h5>
                                            <?php if ($menu_desc) : ?>
                                                <p><?php echo $menu_desc; ?>
                                                <p>
                                                <?php endif ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach   ?>
                        </ul>
                    </ol>
                <?php endif   ?>
            </li>
        <?php endforeach   ?>
    </ul>
    <button class="menu--burger" @click="mobile ? (mobile = false, open = false) : mobile = true">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <span class="menu--overlay" x-show="open" x-cloak @click="open = false"></span>
</nav>