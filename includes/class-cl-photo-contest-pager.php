<?php
/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @author            Carlos Longarela <carlos@longarela.eu>
 * @link              https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 */

/**
 * Pager class.
 *
 * @since      1.0.0
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 * @author     Carlos Longarela <carlos@longarela.eu>
 *
 * @version 0.1 Feb 2005
 * @version 1.2 Feb 2009
 * @version 1.3 Feb 2013
 * @version 1.4 Ago 2013
 * @version 1.5 Mar 2017
 * @version 2.0 Nov 2018
 */
class Cl_Photo_Contest_Pager {

	/**
	 * Total number of registers.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    int   $n_total_registers Total number of registers.
	 */
	private $n_total_registers = 0;

	/**
	 * Number of link pages to show.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    int   $n_links_show Number of link pages to show.
	 */
	private $n_links_show = 10;

	/**
	 * Number of item to show per page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    int   $n_items_per_page Number of item to show per page.
	 */
	private $n_items_per_page = 30;

	/**
	 * Number of pages with the actual number of registers, calculated in constructor.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    int   $n_pages Number of pages with the actual number of registers.
	 */
	private $n_pages_total = 0;

	/**
	 * Our actual page number.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    int   $current_page actual page number..
	 */
	private $current_page = 1;

	/**
	 * Photo Contest url.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $base_contest_url Photo Contest url.
	 */
	private $base_contest_url = '';

	/**
	 * Text to show in link for first page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_first Text to show in link for first page.
	 */
	private $txt_first = '|&lt;';

	/**
	 * Text to show in link for previous page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_previous Text to show in link for previous page.
	 */
	private $txt_previous = '&nbsp;&laquo;';

	/**
	 * Text to show in link for next page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_next Text to show in link for next page.
	 */
	private $txt_next = '&raquo;&nbsp;';

	/**
	 * Text to show in link for last page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_last Text to show in link for last page.
	 */
	private $txt_last = '&gt;|';

	/**
	 * Text to show in link for more page links.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_more_links Text to show in link for more page links.
	 */
	private $txt_more_links = '...';

	/**
	 * Text to show in link for less page links.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $txt_less_links Text to show in link for less page links.
	 */
	private $txt_less_links = '...';

	/**
	 * String with param used for page.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $param_page String with param used for page.
	 */
	private $param_page = 'id_page';

	/**
	 * CSS class for disabled link.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $class_disabled CSS class for disabled link.
	 */
	public $class_disabled = 'cl-photo-contest-link-disabled';

	/**
	 * CSS class for page link.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $class_link_page CSS class for page link.
	 */
	public $class_link_page = 'cl-photo-contest-link';

	/**
	 * CSS class for current page link.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $class_link_current CSS class for current page link.
	 */
	public $class_link_current = 'cl-photo-contest-link-current';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @param string $base_contest_url   Contest photo base url.
	 * @param int    $n_total_registers  Total number of registers.
	 * @param int    $n_items_per_page   Number of item to show per page.
	 */
	public function __construct( $base_contest_url, $n_total_registers, $n_items_per_page = 30 ) {
		$this->n_total_registers = $n_total_registers;
		$this->n_items_per_page  = $n_items_per_page;
		$this->base_contest_url  = $base_contest_url;

		$this->n_pages_total = ceil( $this->n_total_registers / $n_items_per_page );

		$this->current_page = (int) get_query_var( $this->param_page, 1 );
	}

	/**
	 * Set private var $n_links_show to its val.
	 *
	 * @since   1.0.0
	 * @param int $n_links Number of links to show in navigation bar.
	 */
	public function set_n_links_show( $n_links ) {
		$this->n_links_show = absint( $n_links );
	}

	/**
	 * Set private var $txt_first to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_first( $txt ) {
		$this->txt_first = esc_attr( $txt );
	}

	/**
	 * Set private var $txt_previous to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_previous( $txt ) {
		$this->txt_previous = esc_attr( $txt );
	}

	/**
	 * Set private var $txt_next to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_next( $txt ) {
		$this->txt_next = esc_attr( $txt );
	}

	/**
	 * Set private var $txt_last to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_last( $txt ) {
		$this->txt_last = esc_attr( $txt );
	}

	/**
	 * Set private var $txt_more_links to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_more_links( $txt ) {
		$this->txt_more_links = esc_attr( $txt );
	}

	/**
	 * Set private var $txt_less_links to its val.
	 *
	 * @since   1.0.0
	 * @param string $txt Text for private var.
	 */
	public function set_txt_less_links( $txt ) {
		$this->txt_less_links = esc_attr( $txt );
	}

	/**
	 * Set private var $class_disabled to its val.
	 *
	 * @since   1.0.0
	 * @param string $class Text for private var.
	 */
	public function set_class_disabled( $class ) {
		$this->class_disabled = esc_attr( $class );
	}

	/**
	 * Set private var $class_link_page to its val.
	 *
	 * @since   1.0.0
	 * @param string $class Text for private var.
	 */
	public function set_class_link_page( $class ) {
		$this->class_link_page = esc_attr( $class );
	}

	/**
	 * Set private var $class_link_current to its val.
	 *
	 * @since   1.0.0
	 * @param string $class Text for private var.
	 */
	public function set_class_link_current( $class ) {
		$this->class_link_current = esc_attr( $class );
	}

	/**
	 * Set private var $param_page to its val.
	 *
	 * @since   1.0.0
	 * @param string $param Text for private var.
	 */
	public function set_param_page( $param ) {
		$this->param_page = esc_attr( $param );
	}

	/**
	 * Set current page number.
	 *
	 * @since   1.0.0
	 * @param int $page_number Page number to set.
	 */
	private function set_current_page( $page_number ) {
		$this->current_page = $page_number;
	}

	/**
	 * Show links to first page and previous page.
	 */
	private function show_previous() {
		$html = '';

		if ( 1 === $this->current_page ) {
			$html .= '<span class="' . $this->class_disabled . '">' . $this->txt_first . $this->txt_previous . '</span>';
		} else {
			$html .= '<a href="' . esc_url( $this->base_contest_url ) . '" class="' . $this->class_link_page . '">' . $this->txt_first . '</a>';
			if ( 1 === ( $this->current_page - 1 ) ) { // If current page is first page.
				$html .= '<a href="' . esc_url( $this->base_contest_url ) . '" class="' . $this->class_link_page . '">' . $this->txt_previous . '</a>';
			} else {
				$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, ( $this->current_page - 1 ), $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $this->txt_previous . '</a>';
			}
		}

		return $html;
	}

	/**
	 * Show links to last page and next page.
	 */
	private function show_next() {
		$html = '';
		if ( $this->current_page === $this->n_pages_total ) {
			$html .= '<span class="' . $this->class_disabled . '">' . $this->txt_next . $this->txt_last . '</span>';
		} else {
			$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, ( $this->current_page + 1 ), $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $this->txt_next . '</a>';
			$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, $this->n_pages_total, $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $this->txt_last . '</a>';
		}

		return $html;
	}

	/**
	 * Show links for each navigation pages.
	 */
	public function show_nav_bar_pages() {
		$n_pages_total    = $this->n_pages_total;
		$n_items_per_page = $this->n_items_per_page;
		$init             = 1;
		$html             = '';

		for ( $i = 1; $i <= $n_pages_total; $i += $n_items_per_page ) {
			if ( $this->current_page >= $i ) {
				$init = $i;
			}
		}

		$end = $init + $n_items_per_page - 1;

		if ( $end > $n_pages_total ) {
			$end = $n_pages_total;
		}

		if ( $init > 1 ) {
			$pos   = $init - 1;
			$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, $pos, $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $this->txt_less_links . '</a>';
		}

		for ( $i = $init; $i <= $end; $i++ ) {
			if ( $this->current_page === $i || ( 0 === $this->current_page && 1 === $i ) ) {
				$html .= '<span class="' . $this->class_link_current . '">' . $i . '</span>';
			} else {
				if ( 1 === $i ) {
					$html .= '<a href="' . esc_url( $this->base_contest_url ) . '" class="' . $this->class_link_page . '">' . $i . '</a>';
				} else {
					$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, $i, $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $i . '</a>';
				}
			}
		}

		if ( $end < $n_pages_total ) {
			$html .= '<a href="' . esc_url( add_query_arg( $this->param_page, $i, $this->base_contest_url ) ) . '" class="' . $this->class_link_page . '">' . $this->txt_more_links . '</a>';
		}

		return $html;
	}

	/**
	 * Show current page number and total pages number.
	 */
	public function show_actual_page_count() {
		// Translators: Current page and total pages. e.g. Page 1 of 18.
		$html = sprintf( esc_html__( 'Page %1$d of %2$d', 'cl-photo-contest' ), $this->current_page, $this->n_pages_total );
		return $html;
	}

	/**
	 * Show nav bar with options:
	 * - first page and previous page,
	 * - navigate by page numbers,
	 * - next and last page.
	 */
	public function show_nav_bar() {
		$html = '';

		$html .= $this->show_previous();
		$html .= $this->show_nav_bar_pages();
		$html .= $this->show_next();

		return $html;
	}

}
