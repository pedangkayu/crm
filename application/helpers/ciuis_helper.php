<?php
defined( 'BASEPATH' )or exit( 'No direct script access allowed' );
function weekdays() {
	return array(
		'' . lang( 'monday' ) . '',
		'' . lang( 'tuesday' ) . '',
		'' . lang( 'wednesday' ) . '',
		'' . lang( 'thursday' ) . '',
		'' . lang( 'friday' ) . '',
		'' . lang( 'saturday' ) . '',
		'' . lang( 'sunday' ) . '',
	);
}

function months() {
	return array(
		'' . lang( 'january' ) . '',
		'' . lang( 'february' ) . '',
		'' . lang( 'march' ) . '',
		'' . lang( 'april' ) . '',
		'' . lang( 'may' ) . '',
		'' . lang( 'june' ) . '',
		'' . lang( 'july' ) . '',
		'' . lang( 'august' ) . '',
		'' . lang( 'september' ) . '',
		'' . lang( 'october' ) . '',
		'' . lang( 'november' ) . '',
		'' . lang( 'december' ) . '',
	);
}

function weekdays_git() {
	return array(
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday',
		'Sunday'
	);
}

function ciuis_colors() {
	$colors = array(
		'#28B8DA',
		'#03a9f4',
		'#c53da9',
		'#757575',
		'#8e24aa',
		'#d81b60',
		'#0288d1',
		'#7cb342',
		'#fb8c00',
		'#84C529',
		'#fb3b3b'
	);

	return $colors;
}

function email_config() {
	$ci =& get_instance();
	$class = $ci->db->query("SELECT * FROM settings");
    $class = $class->result_array();
	return $class;
}
function ciuis_set_color( $hex, $steps ) {
	$steps = max( -255, min( 255, $steps ) );
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	$color_parts = str_split( $hex, 2 );
	$return = '#';
	foreach ( $color_parts as $color ) {
		$color = hexdec( $color );
		$color = max( 0, min( 255, $color + $steps ) );
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT );
	}
	return $return;
}

function _date( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d.%m.%y", strtotime( $date ) );
}

function _adate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return date( "j F Y, g:i a", strtotime( $date ) );
}

function _dDay( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d", strtotime( $date ) );
}

function _pdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%Y-%m-%d", strtotime( $date ) );
}

function _phdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%Y-%m-%d H:i", strtotime( $date ) );
}


// DATE TYPE
// 3000.12.01
function _rdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%Y.%m.%m", strtotime( $date ) );
}
// 01.12.3000
function _udate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d.%m.%Y", strtotime( $date ) );
}
// 3000-12-01
function _mdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%y-%m-%d", strtotime( $date ) );
}
// 01-12-3000
function _cdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d-%m-%y", strtotime( $date ) );
}
function _cxdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d-%m-%Y", strtotime( $date ) );
}
// 3000/12/01
function _zdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%y/%m/%d", strtotime( $date ) );
}
// 01/12/3000
function _kdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d/%m/%y", strtotime( $date ) );
}
function _ktdate( $date ) {
	if ( $date == '' || is_null( $date ) || $date == '0000-00-00' ) {
		return '';
	}
	return strftime( "%d/%m/%y", strtotime( $date ) );
}
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}