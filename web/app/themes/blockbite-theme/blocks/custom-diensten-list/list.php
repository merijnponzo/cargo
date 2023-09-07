<?php
// query max 10
query_posts(array(
    'post_type' => "diensten",
    'showposts' => 10
));
?>
<ul>
    <?php while (have_posts()) : the_post(); ?>
        <li>
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </li>
    <?php endwhile; ?>
</ul>
<?php wp_reset_query(); ?>