<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Staff extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'staff' );
		$data[ 'staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'departments' ] = $this->Settings_Model->get_departments();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'staff/index', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function create() {
		if ( $this->Staff_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
			echo lang( 'staffemailalreadyexists' );
		} else {
			$data[ 'title' ] = 'Add Staff';
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				switch ( $_POST[ 'admin' ] ) {
					case 'true':
						$is_Admin = 1;
						break;
					case 'false':
						$is_Admin = null;
						break;
				}
				switch ( $_POST[ 'staffmember' ] ) {
					case 'true':
						$is_Staff = 1;
						break;
					case 'false':
						$is_Staff = null;
						break;
				}
				switch ( $_POST[ 'inactive' ] ) {
					case 'true':
						$is_Active = null;
						break;
					case 'false':
						$is_Active = 0;
						break;
				}
				$params = array(
					'language' => $this->input->post( 'language' ),
					'staffname' => $this->input->post( 'name' ),
					'staffavatar' => 'n-img.jpg',
					'department_id' => $this->input->post( 'department' ),
					'phone' => $this->input->post( 'phone' ),
					'address' => $this->input->post( 'address' ),
					'email' => $this->input->post( 'email' ),
					'password' => md5( $this->input->post( 'password' ) ),
					'birthday' => $this->input->post( 'birthday' ),
					'admin' => $is_Admin,
					'staffmember' => $is_Staff,
					'inactive' => $is_Active,
				);
				$staff_id = $this->Staff_Model->add_staff( $params );
				$setconfig = $this->Settings_Model->get_settings_ciuis();
				$this->load->library( 'email' );
				$config = array();
				$config[ 'protocol' ] = 'smtp';
				$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
				$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
				$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
				$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
				$sender = $setconfig[ 'sendermail' ];
				$data = array(
					'name' => $this->session->userdata( 'name' ),
					'password' => $this->input->post( 'password' ),
					'email' => $this->input->post( 'email' ),
					'loginlink' => '' . base_url( 'login' ) . ''
				);
				$body = $this->load->view( 'email/accountinfo.php', $data, TRUE );
				$this->email->initialize( $config );
				$this->email->set_newline( "\r\n" );
				$this->email->set_mailtype( "html" );
				$this->email->from( $sender ); // change it to yours
				$this->email->to( $this->input->post( 'email' ) ); // change it to yours
				$this->email->subject( 'Your Login Informations' );
				$this->email->message( $body );
				if ( $this->email->send() ) {
					$message = sprintf( lang( 'addedstaff' ), $this->input->post( 'name' ) );
					echo $message;
				} else {
					$message = sprintf( lang( 'addedstaffbut' ), $this->input->post( 'name' ) );
					echo $message;
				}


			} else {
				$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
				$data[ 'languages' ] = $this->Settings_Model->get_languages();
				$data[ 'departments' ] = $this->Settings_Model->get_departments();
				$this->load->view( 'staff/add', $data );
			}

		}
	}

	function update( $id ) {
		if ( isset( $id ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				switch ( $_POST[ 'admin' ] ) {
					case 'true':
						$is_Admin = 1;
						break;
					case 'false':
						$is_Admin = null;
						break;
				}
				switch ( $_POST[ 'staffmember' ] ) {
					case 'true':
						$is_Staff = 1;
						break;
					case 'false':
						$is_Staff = null;
						break;
				}
				switch ( $_POST[ 'inactive' ] ) {
					case 'true':
						$is_Active = null;
						break;
					case 'false':
						$is_Active = 0;
						break;
				}
				$params = array(
					'language' => $this->input->post( 'language' ),
					'staffname' => $this->input->post( 'name' ),
					'department_id' => $this->input->post( 'department' ),
					'phone' => $this->input->post( 'phone' ),
					'address' => $this->input->post( 'address' ),
					'email' => $this->input->post( 'email' ),
					'birthday' => $this->input->post( 'birthday' ),
					'admin' => $is_Admin,
					'staffmember' => $is_Staff,
					'inactive' => $is_Active,
				);
				$this->Staff_Model->update_staff( $id, $params );
				echo lang( 'staffupdated' );
			}
		}
	}

	function update_privileges( $id ) {
		$permissions = $this->input->post( 'permissions' );
		$insert = $this->Privileges_Model->add_privilege( $id, $permissions );
		if ( $insert ) {
			$this->session->set_flashdata( 'ntf1', '' . lang( 'privileges_updated' ) . '' );
			redirect( 'staff/staffmember/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf1', '' . lang( 'privileges_not_updated' ) . '' );
			redirect( 'staff/staffmember/' . $id . '' );
		}
	}

	function staffmember( $id ) {
		$data[ 'title' ] = lang( 'staffdetail' );
		$data[ 'staff' ] = $this->Staff_Model->get_staff( $id );
		$data[ 'permissions' ] = $this->Privileges_Model->get_all_permissions();
		$data[ 'privileges' ] = $this->Privileges_Model->get_privileges();
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'staff/detail', $data );
		$this->load->view( 'inc/footer', $data );

	}

	function change_avatar( $id ) {
		if ( isset( $id ) ) {
			if ( isset( $_POST ) ) {
				$config[ 'upload_path' ] = './uploads/images/';
				$config[ 'allowed_types' ] = 'gif|jpg|png|jpeg';
				$this->load->library( 'upload', $config );
				$this->upload->do_upload( 'file_name' );
				$data_upload_files = $this->upload->data();
				$image_data = $this->upload->data();
				$params = array(
					'staffavatar' => $image_data[ 'file_name' ],
				);
				$response = $this->Staff_Model->update_staff( $id, $params );
				redirect( 'staff/staffmember/' . $id . '' );
			}
		}
	}

	function remove( $id ) {
		$staff = $this->Staff_Model->get_staff( $id );
		// check if the staff exists before trying to delete it
		if ( isset( $staff[ 'id' ] ) ) {
			$this->Staff_Model->delete_staff( $id );
			redirect( 'staff/index' );
		} else
			show_error( 'The staff you are trying to delete does not exist.' );
	}

	function add_department() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
			);
			$department = $this->Settings_Model->add_department( $params );
			echo $department;
		}
	}

	function update_department( $id ) {
		$departments = $this->Settings_Model->get_department( $id );
		if ( isset( $departments[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
				);
				$this->session->set_flashdata( 'ntf1', '<span><b>' . lang( 'departmentupdated' ) . '</b></span>' );
				$this->Settings_Model->update_department( $id, $params );
			}
		}
	}

	function remove_department( $id ) {
		$departments = $this->Settings_Model->get_department( $id );
		if ( isset( $departments[ 'id' ] ) ) {
			$this->Settings_Model->delete_department( $id );
			redirect( 'staff/index' );
		}
	}

	function appointment_availability( $id, $value ) {
		if ( $value === 'true' ) {
			$availability = 1;
		} else {
			$availability = 0;
		}
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'staff', array( 'appointment_availability' => $availability ) );
		};
	}

	function changestaffpassword( $id ) {
		$staff = $this->Staff_Model->get_staff( $id );
		if ( isset( $staff[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'password' => md5( $this->input->post( 'password' ) ),
				);
				// SEND EMAIL SETTINGS
				$setconfig = $this->Settings_Model->get_settings_ciuis();
				$this->load->library( 'email' );
				$config = array();
				$config[ 'protocol' ] = 'smtp';
				$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
				$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
				$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
				$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
				$sender = $setconfig[ 'sendermail' ];
				$data = array(
					'name' => $this->session->userdata( 'staffname' ),
					'password' => $this->input->post( 'password' ),
					'email' => $staff[ 'email' ],
					'loginlink' => '' . base_url( 'login' ) . ''
				);
				$body = $this->load->view( 'email/passwordchanged.php', $data, TRUE );
				$this->email->initialize( $config );
				$this->email->set_newline( "\r\n" );
				$this->email->set_mailtype( "html" );
				$this->email->from( $sender ); // change it to yours
				$this->email->to( $staff[ 'email' ] ); // change it to yours
				$this->email->subject( 'Your Password Changed' );
				$this->email->message( $body );
				if ( $this->email->send() ) {
					$staffname1 = $this->session->staffname;
					$staffname2 = $staff[ 'staffname' ];
					$loggedinuserid = $this->session->usr_id;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $message = sprintf( lang( 'changedstaffpassword' ), $staffname1, $staffname2 ) . '' ),
						'staff_id' => $loggedinuserid,
					) );
					$this->Staff_Model->update_staff( $id, $params );
					$this->session->set_flashdata( 'ntf1', ' ' . $staff[ 'staffname' ] . ' ' . lang( 'passwordchanged' ) . '' );
					echo ' ' . $staff[ 'staffname' ] . ' ' . lang( 'passwordchanged' ) . '';
				} else {
					/////////////
					//LOG
					$staffname1 = $this->session->staffname;
					$staffname2 = $staff[ 'staffname' ];
					$loggedinuserid = $this->session->usr_id;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $message = sprintf( lang( 'changedstaffpassword' ), $staffname1, $staffname2 ) . '' ),
						'staff_id' => $loggedinuserid,
					) );
					$this->Staff_Model->update_staff( $id, $params );
					$this->session->set_flashdata( 'ntf4', ' ' . $staff[ 'staffname' ] . ' ' . lang( 'passwordchangedbut' ) . '' );
					echo ' ' . $staff[ 'staffname' ] . ' ' . lang( 'passwordchangedbut' ) . '';
				}

			} else {
				$data[ 'staff' ] = $this->Staff_Model->get_staff( $id );
			}
		} else
			show_error( 'The contacts you are trying to edit does not exist.' );
	}
}