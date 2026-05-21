<?php
/**
 * Đăng ký block hiển thị bài viết mới nhất có phân trang
 */
function dev_register_latest_posts_block() {
    register_block_type( 'dev/latest-posts-pagination', [
        'title'           => __( 'Bài viết mới nhất (Phân trang)', 'dev-textdomain' ),
        'icon'            => 'list-view',
        'category'        => 'widgets',
        'attributes'      => [
            'postsPerPage' => [
                'type'    => 'number',
                'default' => 5,
            ],
        ],
        'render_callback' => 'dev_render_latest_posts_block',
    ] );
}
add_action( 'init', 'dev_register_latest_posts_block' );

/**
 * Hàm render callback xử lý logic và hiển thị HTML
 */
function dev_render_latest_posts_block( $attributes ) {
    // Tránh xung đột phân trang trên Trang chủ tĩnh / Trang tĩnh
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

    $args = [
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $attributes['postsPerPage'],
        'paged'               => $paged,
        'ignore_sticky_posts' => true,
    ];

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '<p>' . __( 'Không có bài viết nào.', 'dev-textdomain' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="wp-block-dev-latest-posts-pagination">
        <!-- List Posts -->
        <ul class="posts-list">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <li class="post-item">
                    <h3 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="post-meta"><?php echo get_the_date(); ?></div>
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- Pagination -->
        <div class="posts-pagination">
            <?php
            echo paginate_links( [
                'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'format'    => '?paged=%#%',
                'current'   => $paged,
                'total'     => $query->max_num_pages,
                'type'      => 'list',
                'prev_text' => __( '&laquo; Trước', 'dev-textdomain' ),
                'next_text' => __( 'Tiếp &raquo;', 'dev-textdomain' ),
            ] );
            ?>
        </div>
    </div>
    <?php
    wp_reset_postdata();

    return ob_get_clean();
}