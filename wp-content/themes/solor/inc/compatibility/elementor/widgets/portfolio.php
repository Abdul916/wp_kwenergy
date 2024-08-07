<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Ata_Widget_Portfolio extends Widget_Base {

	private $_query = null;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'portfolio-grid';
	}

	public function get_title() {
		return __( 'Portfolio Grid', 'solor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_script_depends() {
		return [
			'imagesloaded',
		];
	}

	public function get_query() {
		return $this->_query;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'solor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'solor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
			]
		);



		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts Per Page', 'solor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 99,
			]
		);

		$this->end_controls_section();
	
	}

	public function query_posts() {
		$query_params = array(
            'post_type' => 'awaiken-portfolio',
            'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'desc',
            'posts_per_page' => $this->get_settings( 'posts_per_page' ),
			'taxonomy' => 'awaiken-portfolio-category',
        );

		$wp_query = new \WP_Query( $query_params );

		$this->_query = $wp_query;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->have_posts() ) {
			return;
		}

		?>
		<div class="projects-box" id="awaiken-portfolio-<?php echo esc_attr($this->get_id()); ?>">
			<div class="project-items">
		<?php 

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			?>
			<div class="project-item">
				
				<?php 
				if ( has_post_thumbnail() ) : ?>
					<div class="project-image">
						<figure class="image-anime">
							<?php the_post_thumbnail(); ?>
						</figure>
					</div>
				<?php endif; ?>
					<div class="content-button">
						<div class="project-content">
							<h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
							<?php 
								$category 	= '';
								$terms	 	= get_the_terms( get_the_ID(), 'awaiken-portfolio-category' );
								if ( ! empty( $terms ) ) {								
									foreach($terms as $term) {
										$category = $term->name;
										break;
									}
								}
								if($category) {
							?>
							<p><?php echo esc_html($category); ?></p>
							<?php } ?>
						</div>

						<div class="project-link">
							<a href="<?php echo esc_url(get_permalink()); ?>"> <i class="fa-solid fa-arrow-right-long"></i></a>
						</div>
					</div>
				</div>
			<?php 
		}
		?>
				</div>
			</div>
		<?php 

		wp_reset_postdata();

	}


}
