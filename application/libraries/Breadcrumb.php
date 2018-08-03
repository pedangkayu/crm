<?php
class Breadcrumb {
	public $link_type = ' &rsaquo; ';
	public $breadcrumb = array();
	public $output = '';
	public
	function clear() {
		$props = array( 'breadcrumb', 'output' );

		foreach ( $props as $val ) {
			$this->$val = null;
		}

		return true;
	}
	public
	function add_crumb( $title, $url = false ) {
		$this->breadcrumb[] =
			array(
				'title' => $title,
				'url' => $url
			);

		return true;
	}
	public
	function change_link( $new_link ) {
		$this->link_type = ' ' . $new_link . ' ';
		return true;
	}
	public
	function output() {
		$counter = 0;

		foreach ( $this->breadcrumb as $val ) {
			if ( $counter > 0 ) {
				$this->output .= $this->link_type;
			}

			if ( $val[ 'url' ] ) {
				$this->output .= '<li><a href="' . $val[ 'url' ] . '">' . $val[ 'title' ] . '</a></li>';
			} else {
				$this->output .= $val[ 'title' ];
			}

			$counter++;
		}

		return $this->output;
	}
}