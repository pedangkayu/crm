<?php
class Settings_Model extends CI_Model {
	function get_settings( $settingname ) {
		$this->db->select( '*,countries.shortname as country,languages.name as language, currencies.name as currencyname,currencies.code as currency,settings.settingname as settingname ' );
		$this->db->join( 'languages', 'settings.languageid = languages.foldername', 'left' );
		$this->db->join( 'currencies', 'settings.currencyid = currencies.id', 'left' );
		$this->db->join( 'countries', 'settings.country_id = countries.id', 'left' );
		return $this->db->get_where( 'settings', array( 'settingname' => $settingname ) )->row_array();
	}

	function get_settings_ciuis() {
		$this->db->select( '*,countries.shortname as country,languages.name as language, currencies.name as currencyname,currencies.code as currency,settings.settingname as settingname ' );
		$this->db->join( 'languages', 'settings.languageid = languages.foldername', 'left' );
		$this->db->join( 'currencies', 'settings.currencyid = currencies.id', 'left' );
		$this->db->join( 'countries', 'settings.country_id = countries.id', 'left' );
		return $this->db->get_where( 'settings', array( 'settingname' === 'ciuis' ) )->row_array();
	}
	
	function get_settings_ciuis_origin() {
		return $this->db->get_where( 'settings', array( 'settingname' === 'ciuis' ) )->row_array();
	}

	function update_settings( $settingname, $params ) {
		$this->db->where( 'settingname', $settingname );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updatedsettings' ) . '' ),
			'staff_id' => $loggedinuserid
		) );
		$response = $this->db->update( 'settings', $params );
	}

	function get_currencies() {
		return $this->db->get_where( 'currencies', array( '' ) )->result_array();
	}
	function get_languages() {
		return $this->db->get_where( 'languages', array( '' ) )->result_array();
	}
	function get_department( $id ) {
		return $this->db->get_where( 'departments', array( 'id' => $id ) )->row_array();
	}

	function get_departments() {
		return $this->db->get_where( 'departments', array( '' ) )->result_array();
	}
	function add_department( $params ) {
		$this->db->insert( 'departments', $params );
		return $this->db->insert_id();
	}
	function update_department( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'departments', $params );
	}
	function delete_department( $id ) {
		$response = $this->db->delete( 'departments', array( 'id' => $id ) );
	}
	function get_menus() {
		if (!if_admin) {
			return $this->db->get_where( 'menu', array( 'main_menu' => '0' ) )->result_array();
		}else{
			return $this->db->get_where( 'menu', array( 'main_menu' => '0', 'show_staff' => '0') )->result_array();
		};
		
	}
	function get_submenus( $id ) {
		if (!if_admin) {
			return $this->db->get_where( 'menu', array( 'main_menu' => $id ) )->result_array();
		}else{
			return $this->db->get_where( 'menu', array( 'main_menu' => $id, 'show_staff' => '0') )->result_array();
		};
	}

	function get_crm_lang() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->languageid;
        }
    }
	function default_timezone() {
        $query = $this->db->get('settings');
        $row = $query->row();
        return $row->default_timezone;
    }
	
	function two_factor_authentication() {
        $query = $this->db->get('settings');
        $row = $query->row();
        return $row->two_factor_authentication;
    }
	
	function get_currency() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $currencyid =  $row->currencyid;
        }
		$this->db->limit(1, 0);
        $query = $this->db->get_where( 'currencies', array( 'id' => $currencyid ));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        }
    }
	public function load_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }
}