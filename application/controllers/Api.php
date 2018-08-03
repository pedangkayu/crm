<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Api extends CIUIS_Controller {

	function index() {
		echo 'Ciuis RestAPI Service';
	}

	function settings() {
		$settings = $this->Settings_Model->get_settings_ciuis();
		echo json_encode( $settings );
	}

	function settings_detail() {
		$settings = $this->Settings_Model->get_settings_ciuis_origin();
		echo json_encode( $settings );
	}

	function languages() {
		$languages = $this->Settings_Model->get_languages();
		echo json_encode( $languages );
	}

	function currencies() {
		$currencies = $this->Settings_Model->get_currencies();
		echo json_encode( $currencies );
	}

	function timezones() {
		$jsonstring = include( 'assets/json/timezones.json' );
		$obj = json_decode( $jsonstring );
		print_r( $obj[ 'Data' ] );
	}

	function upload_attachmet() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$config[ 'upload_path' ] = './uploads/attachments/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'fd' );
			$data_upload_files = $this->upload->data();
			$file_data = $this->upload->data();
			echo $file_data[ 'file_name' ];
		} else {
			echo 'null';
		}
	}

	function stats() {
		$otc = $this->Report_Model->otc();
		$yms = $this->Report_Model->yms();
		$bkt = $this->Report_Model->bkt();
		$ogt = $this->Report_Model->ogt();
		$pay = $this->Report_Model->pay();
		$exp = $this->Report_Model->exp();
		$bht = $this->Report_Model->bht();
		$ohc = $this->Report_Model->ohc();
		$oak = $this->Report_Model->oak();
		$akt = $this->Report_Model->akt();
		$mex = $this->Report_Model->mex();
		$pme = $this->Report_Model->pme();
		$ycr = $this->Report_Model->ycr();
		$oyc = $this->Report_Model->oyc();
		if ( $otc > 1 ) {
			$newticketmsg = lang( 'newtickets' );
		} else $newticketmsg = lang( 'newticket' );
		if ( $yms > 1 ) {
			$newcustomermsg = lang( 'newcustomers' );
		} else $newcustomermsg = lang( 'newcustomer' );
		if ( $bkt > $ogt ) {
			$todaysalescolor = 'default';
		} else {
			$todaysalescolor = 'danger';
		}
		$todayrate = $bkt - $ogt;
		if ( empty( $ogt ) ) {
			$todayrate = 'N/A';
		} else $todayrate = floor( $todayrate / $ogt * 100 );
		if ( $bkt > $ogt ) {
			$todayicon = 'icon ion-arrow-up-c';
		} else {
			$todayicon = 'icon ion-arrow-down-c';
		}
		$netcashflow = ( $pay - $exp );
		if ( $bht > $ohc ) {
			$weekstat = 'default';
		} else {
			$weekstat = 'danger';
		}
		$weekrate = $bht - $ohc;
		if ( empty( $ohc ) ) {
			$weekrate = 'N/A';
		} else $weekrate = floor( $weekrate / $ohc * 100 );
		if ( $bht > $ohc ) {
			$weekratestatus = lang( 'increase' );
		} else {
			$weekratestatus = lang( 'recession' );
		}
		if ( $akt > $oak ) {
			$montearncolor = 'success';
			$monicon = 'icon ion-arrow-up-c';
		} else {
			$montearncolor = 'danger';
			$monicon = 'icon ion-arrow-down-c';
		}
		$oao = $akt - $oak;
		if ( empty( $oak ) ) {
			$monmessage = '' . lang( 'notyet' ) . '';
		} else $monmessage = floor( $oao / $oak * 100 );
		$time = date( "H" );
		$timezone = date( "e" );
		if ( $time < "12" ) {
			$daymessage = lang( 'goodmorning' );
			$dayimage = 'morning.png';
		} else if ( $time >= "12" && $time < "17" ) {
			$daymessage = lang( 'goodafternoon' );
			$dayimage = 'afternoon.png';
		} else if ( $time >= "17" && $time < "19" ) {
			$daymessage = lang( 'goodevening' );
			$dayimage = 'evening.png';
		} else if ( $time >= "19" ) {
			$daymessage = lang( 'goodnight' );
			$dayimage = 'night.png';
		}
		if ( $mex > $pme ) {
			$expensecolor = 'warning';
		} else {
			$expensecolor = 'danger';
		}
		if ( $mex > $pme ) {
			$expenseicon = 'icon ion-arrow-up-c';
		} else {
			$expenseicon = 'icon ion-arrow-down-c';
		}
		$expenses = $mex - $pme;
		if ( empty( $pme ) ) {
			$expensestatus = '' . lang( 'notyet' ) . '';
		} else $expensestatus = floor( $expenses / $pme * 100 );
		if ( $ycr > $oyc ) {
			$yearcolor = 'success';
		} else {
			$yearcolor = 'danger';
		}
		if ( $ycr > $oyc ) {
			$yearicon = 'icon ion-arrow-up-c';
		} else {
			$yearicon = 'icon ion-arrow-down-c';
		}
		$yearly = $ycr - $oyc;
		if ( empty( $oyc ) ) {
			$yearmessage = '' . lang( 'notyet' ) . '';
		} else $yearmessage = floor( $yearly / $oyc * 100 );
		$stats = array(
			'mex' => $mex = $this->Report_Model->mex(),
			'pme' => $pme = $this->Report_Model->pme(),
			'bkt' => $bkt = $this->Report_Model->bkt(),
			'bht' => $bht = $this->Report_Model->bht(),
			'ogt' => $ogt = $this->Report_Model->ogt(),
			'ohc' => $ohc = $this->Report_Model->ohc(),
			'otc' => $otc = $this->Report_Model->otc(),
			'ycr' => $ycr = $this->Report_Model->ycr(),
			'oyc' => $oyc = $this->Report_Model->oyc(),
			'oft' => $oft = $this->Report_Model->oft(),
			'tef' => $tef = $this->Report_Model->tef(),
			'vgf' => $vgf = $this->Report_Model->vgf(),
			'tbs' => $tbs = $this->Report_Model->tbs(),
			'akt' => $akt = $this->Report_Model->akt(),
			'oak' => $oak = $this->Report_Model->oak(),
			'tfa' => $tfa = $this->Report_Model->tfa(),
			'yms' => $yms = $this->Report_Model->yms(),
			'ttc' => $ttc = $this->Report_Model->ttc(),
			'ipc' => $ipc = $this->Report_Model->ipc(),
			'atc' => $atc = $this->Report_Model->atc(),
			'ctc' => $ctc = $this->Report_Model->ctc(),
			'put' => $put = $this->Report_Model->put(),
			'pay' => $pay = $this->Report_Model->pay(),
			'exp' => $exp = $this->Report_Model->exp(),
			'twt' => $twt = $this->Report_Model->twt(),
			'clc' => $clc = $this->Report_Model->clc(),
			'mlc' => $mlc = $this->Report_Model->mlc(),
			'mtt' => $mtt = $this->Report_Model->mtt(),
			'mct' => $mct = $this->Report_Model->mct(),
			'ues' => $ues = $this->Report_Model->ues(),
			'myc' => $myc = $this->Report_Model->myc(),
			'tpz' => $tpz = $this->Report_Model->tpz(),
			'nsp' => $nsp = $this->Report_Model->nsp(),
			'sep' => $sep = $this->Report_Model->sep(),
			'pep' => $pep = $this->Report_Model->pep(),
			'cap' => $cap = $this->Report_Model->cap(),
			'cop' => $cop = $this->Report_Model->cop(),
			'tht' => $cop = $this->Report_Model->tht(),
			'total_incomings' => $cop = $this->Report_Model->total_incomings(),
			'total_outgoings' => $cop = $this->Report_Model->total_outgoings(),
			'not_started_percent' => $nspp = ( $tpz > 0 ? number_format( ( $nsp * 100 ) / $tpz ) : 0 ),
			'started_percent' => $sppp = ( $tpz > 0 ? number_format( ( $sep * 100 ) / $tpz ) : 0 ),
			'percentage_percent' => $pppp = ( $tpz > 0 ? number_format( ( $pep * 100 ) / $tpz ) : 0 ),
			'cancelled_percent' => $cppp = ( $tpz > 0 ? number_format( ( $cap * 100 ) / $tpz ) : 0 ),
			'complete_percent' => $comps = ( $tpz > 0 ? number_format( ( $cop * 100 ) / $tpz ) : 0 ),
			'totalpaym' => $totalpaym = $this->Report_Model->totalpaym(),
			'incomings' => $incomings = $this->Report_Model->incomings(),
			'outgoings' => $outgoings = $this->Report_Model->outgoings(),
			'ysy' => $ysy = ( $ttc > 0 ? number_format( ( $otc * 100 ) / $ttc ) : 0 ),
			'bsy' => $bsy = ( $ttc > 0 ? number_format( ( $ipc * 100 ) / $ttc ) : 0 ),
			'twy' => $twy = ( $ttc > 0 ? number_format( ( $atc * 100 ) / $ttc ) : 0 ),
			'iey' => $iey = ( $ttc > 0 ? number_format( ( $ctc * 100 ) / $ttc ) : 0 ),
			'ofy' => $ofy = ( $tfa > 0 ? number_format( ( $tef * 100 ) / $tfa ) : 0 ),
			'clp' => $clp = ( $mlc > 0 ? number_format( ( $clc * 100 ) / $mlc ) : 0 ),
			'mtp' => $mtp = ( $mtt > 0 ? number_format( ( $mct * 100 ) / $mtt ) : 0 ),
			'inp' => $inp = ( $put > 0 ? number_format( ( $pay * 100 ) / $put ) : 0 ),
			'ogp' => $ogp = ( $put > 0 ? number_format( ( $exp * 100 ) / $put ) : 0 ),
			'newticketmsg' => $newticketmsg,
			'newcustomermsg' => $newcustomermsg,
			'todaysalescolor' => $todaysalescolor,
			'todayrate' => $todayrate,
			'todayicon' => $todayicon,
			'netcashflow' => $netcashflow,
			'weekstat' => $weekstat,
			'weekrate' => $weekrate,
			'weekratestatus' => $weekratestatus,
			'daymessage' => $daymessage,
			'dayimage' => $dayimage,
			'montearncolor' => $montearncolor,
			'monicon' => $monicon,
			'monmessage' => $monmessage,
			'expensecolor' => $expensecolor,
			'expenseicon' => $expenseicon,
			'expensestatus' => $expensestatus,
			'yearcolor' => $yearcolor,
			'yearicon' => $yearicon,
			'yearmessage' => $yearmessage,
			'newnotification' => $this->Notifications_Model->newnotification(),
			'totaltasks' => $totaltasks = $this->Report_Model->totaltasks(),
			'opentasks' => $opentasks = $this->Report_Model->opentasks(),
			'inprogresstasks' => $inprogresstasks = $this->Report_Model->inprogresstasks(),
			'waitingtasks' => $waitingtasks = $this->Report_Model->waitingtasks(),
			'completetasks' => $completetasks = $this->Report_Model->completetasks(),
			'invoice_chart_by_status' => $invoice_chart_by_status = $this->Report_Model->invoice_chart_by_status(),
			'leads_to_win_by_leadsource' => $leads_to_win_by_leadsource = $this->Report_Model->leads_to_win_by_leadsource(),
			'leads_by_leadsource' => $leads_by_leadsource = $this->Report_Model->leads_by_leadsource(),
			'incomings_vs_outgoins' => $leads_by_leadsource = $this->Report_Model->incomings_vs_outgoins(),
			'expenses_by_categories' => $expenses_by_categories = $this->Report_Model->expenses_by_categories(),
			'top_selling_staff_chart' => $top_selling_staff_chart = $this->Report_Model->top_selling_staff_chart(),
			'weekly_sales_chart' => $weekly_sales_chart = $this->Report_Model->weekly_sales_chart(),
			'monthly_expenses' => $this->Report_Model->monthly_expenses(),
			'months' => months(),
		);
		echo json_encode( $stats );
	}

	function user() {
		$id = $this->session->userdata( 'usr_id' );
		$user = $this->Staff_Model->get_staff( $id );
		$user_data = array(
			'id' => $user[ 'id' ],
			'role_id' => $user[ 'role_id' ],
			'language' => $user[ 'language' ],
			'name' => $user[ 'staffname' ],
			'avatar' => $user[ 'staffavatar' ],
			'department_id' => $user[ 'department_id' ],
			'phone' => $user[ 'phone' ],
			'email' => $user[ 'email' ],
			'birthday' => $user[ 'birthday' ],
			'root' => $user[ 'root' ],
			'admin' => $user[ 'admin' ],
			'staffmember' => $user[ 'staffmember' ],
			'last_login' => $user[ 'last_login' ],
			'inactive' => $user[ 'inactive' ],
			'appointment_availability' => $user[ 'appointment_availability' ],
		);
		echo json_encode( $user_data );
	}

	function staff_detail( $id ) {
		$staff = $this->Staff_Model->get_staff( $id );
		$permissions = $this->Privileges_Model->get_all_permissions();
		$privileges = $this->Privileges_Model->get_privileges();
		$arr = array();
		foreach ( $privileges as $privilege ) {

			if ( $privilege[ 'staff_id' ] == $id ) {
				array_push( $arr, $privilege[ 'permission_id' ] );
			}
		}
		foreach ( $permissions  as $permission ) {
			$staff_privileges[] = array(
				'id' => $permission[ 'id' ],
				'name' => $permission[ 'permission' ],
				'value' => array_search( $permission[ 'id' ], $arr ) !== FALSE,
			);

		};
		switch ( $staff[ 'admin' ] ) {
			case 1:
				$isAdmin = true;
				break;
			case null || 0:
				$isAdmin = false;
				break;
		}
		switch ( $staff[ 'staffmember' ] ) {
			case 1:
				$isStaff = true;
				break;
			case null || 0:
				$isStaff = false;
				break;
		}
		switch ( $staff[ 'inactive' ] ) {
			case null:
				$isInactive = true;
				break;
			case '0':
				$isInactive = false;
				break;
		}
		$properties = array(
			'department' => $staff[ 'department' ],
			'sales_total' => $this->Staff_Model->total_sales_by_staff( $id ),
			'total_customer' => $this->Staff_Model->total_custoemer_by_staff( $id ),
			'total_ticket' => $this->Staff_Model->total_ticket_by_staff( $id ),
			'chart_data' => $this->Report_Model->staff_sales_graph( $id ),
		);
		$user_data = array(
			'id' => $staff[ 'id' ],
			'role_id' => $staff[ 'role_id' ],
			'language' => $staff[ 'language' ],
			'name' => $staff[ 'staffname' ],
			'avatar' => $staff[ 'staffavatar' ],
			'department_id' => $staff[ 'department_id' ],
			'phone' => $staff[ 'phone' ],
			'email' => $staff[ 'email' ],
			'address' => $staff[ 'address' ],
			'birthday' => $staff[ 'birthday' ],
			'admin' => $isAdmin,
			'staffmember' => $isStaff,
			'last_login' => $staff[ 'last_login' ],
			'active' => $isInactive,
			'properties' => $properties,
			'privileges' => $staff_privileges
		);
		echo json_encode( $user_data );
	}

	function menu() {
		$menus = $this->Settings_Model->get_menus();
		$data_menus = array();
		foreach ( $menus as $menu ) {
			$sub_menus = $this->Settings_Model->get_submenus( $menu[ 'id' ] );
			$data_submenus = array();
			foreach ( $sub_menus as $sub_menu ) {
				if ( $this->Privileges_Model->has_privilege( $sub_menu[ 'url' ] ) ) {
					if ( $sub_menu[ 'url' ] != NULL ) {
						$suburl = '' . base_url( $sub_menu[ 'url' ] ) . '';
					} else {
						$suburl = '#';
					}
					$data_submenus[] = array(
						'id' => $sub_menu[ 'id' ],
						'order_id' => $sub_menu[ 'order_id' ],
						'main_menu' => $sub_menu[ 'main_menu' ],
						'name' => lang($sub_menu[ 'name' ]),
						'description' => lang($sub_menu[ 'description' ]),
						'icon' => $sub_menu[ 'icon' ],
						'url' => $suburl,
					);
				}
			};
			if ( $menu[ 'url' ] != NULL ) {
				$url = '' . base_url( $menu[ 'url' ] ) . '';
			} else {
				$url = '#';
			}
			$data_menus[] = array(
				'id' => $menu[ 'id' ],
				'order_id' => $menu[ 'order_id' ],
				'main_menu' => $menu[ 'main_menu' ],
				'name' => lang( '' . $menu[ 'name' ] . '' ),
				'description' => $menu[ 'description' ],
				'icon' => $menu[ 'icon' ],
				'url' => $url,
				'sub_menu' => $data_submenus,
			);
		};
		echo json_encode( $data_menus );
	}

	function leftmenu() {
		if ( !if_admin ) {
			$permission_menu = 0;
		} else $permission_menu = 1;
		$all_menu = array(
			'1' => array(
				'title' => lang( 'x_menu_panel' ),
				'show_staff' => 0,
				'url' => base_url( 'panel' ),
				'icon' => 'ion-ios-analytics-outline',
				'path' => null,
				'show' => 'true'
			),
			'2' => array(
				'title' => lang( 'x_menu_customers' ),
				'show_staff' => 0,
				'url' => base_url( 'customers' ),
				'icon' => 'ico-ciuis-customers',
				'path' => 'customers',
				'show' => 'false'
			),
			'3' => array(
				'title' => lang( 'x_menu_leads' ),
				'show_staff' => 0,
				'url' => base_url( 'leads' ),
				'icon' => 'ico-ciuis-leads',
				'path' => 'leads',
				'show' => 'false'
			),
			'4' => array(
				'title' => lang( 'x_menu_projects' ),
				'show_staff' => 0,
				'url' => base_url( 'projects' ),
				'icon' => 'ico-ciuis-projects',
				'path' => 'projects',
				'show' => 'false'
			),
			'5' => array(
				'title' => lang( 'x_menu_invoices' ),
				'show_staff' => 0,
				'url' => base_url( 'invoices' ),
				'icon' => 'ico-ciuis-invoices',
				'path' => 'invoices',
				'show' => 'false'
			),
			'6' => array(
				'title' => lang( 'x_menu_proposals' ),
				'show_staff' => 0,
				'url' => base_url( 'proposals' ),
				'icon' => 'ico-ciuis-proposals',
				'path' => 'proposals',
				'show' => 'false'
			),
			'7' => array(
				'title' => lang( 'x_menu_expenses' ),
				'show_staff' => 0,
				'url' => base_url( 'expenses' ),
				'icon' => 'ico-ciuis-expenses',
				'path' => 'expenses',
				'show' => 'false'
			),
			'8' => array(
				'title' => lang( 'x_menu_staff' ),
				'show_staff' => $permission_menu,
				'url' => base_url( 'staff' ),
				'icon' => 'ico-ciuis-staff',
				'path' => 'staff',
				'show' => 'false'
			),
			'9' => array(
				'title' => lang( 'x_menu_tickets' ),
				'show_staff' => 0,
				'url' => base_url( 'tickets' ),
				'icon' => 'ico-ciuis-supports',
				'path' => 'tickets',
				'show' => 'false'
			),

		);

		$data_left_menu = array();
		foreach ( $all_menu as $menu ) {
			if ( $this->Privileges_Model->has_privilege( $menu[ 'path' ] ) || $menu[ 'show' ] != 'false' ) {
				$show = true;
			} else {
				$show = false;
			}
			$data_left_menu[] = array(
				'title' => $menu[ 'title' ],
				'show_staff' => $menu[ 'show_staff' ],
				'url' => $menu[ 'url' ],
				'icon' => $menu[ 'icon' ],
				'path' => $menu[ 'path' ],
				'show' => $show
			);
		}

		echo json_encode( $data_left_menu );
	}

	function projects() {
		$projects = $this->Projects_Model->get_all_projects();
		$data_projects = array();
		foreach ( $projects as $project ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			$totaltasks = $this->Report_Model->totalprojecttasks( $project[ 'id' ] );
			$opentasks = $this->Report_Model->openprojecttasks( $project[ 'id' ] );
			$completetasks = $this->Report_Model->completeprojecttasks( $project[ 'id' ] );
			$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
			$project_id = $project[ 'id' ];
			switch ( $project[ 'status' ] ) {
				case '1':
					$projectstatus = 'notstarted';
					$icon = 'notstarted.png';
					$status = lang( 'notstarted' );
					break;
				case '2':
					$projectstatus = 'started';
					$icon = 'started.png';
					$status = lang( 'started' );
					break;
				case '3':
					$projectstatus = 'percentage';
					$icon = 'percentage.png';
					$status = lang( 'percentage' );
					break;
				case '4':
					$projectstatus = 'cancelled';
					$icon = 'cancelled.png';
					$status = lang( 'cancelled' );
					break;
				case '5':
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang( 'complete' );
					break;
			}
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $project[ 'start_date' ] );
					break;
				case 'dd.mm.yy':
					$startdate = _udate( $project[ 'start_date' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $project[ 'start_date' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $project[ 'start_date' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $project[ 'start_date' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $project[ 'start_date' ] );
					break;
			};
			if ( $project[ 'customercompany' ] === NULL ) {
				$customer = $project[ 'namesurname' ];
			} else $customer = $project[ 'customercompany' ];
			$enddate = $project[ 'deadline' ];
			$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( 'Asia/Dhaka' ) );
			$end_date = new DateTime( "$enddate", new DateTimeZone( 'Asia/Dhaka' ) );
			$interval = $current_date->diff( $end_date );
			$leftdays = $interval->format( '%a day(s)' );
			$members = $this->Projects_Model->get_members_index( $project_id );
			$milestones = $this->Projects_Model->get_all_project_milestones( $project_id );
			$data_projects[] = array(
				'id' => $project[ 'id' ],
				'project_id' => $project[ 'id' ],
				'name' => $project[ 'name' ],
				'pinned' => $project[ 'pinned' ],
				'progress' => $progress,
				'startdate' => $startdate,
				'leftdays' => $leftdays,
				'customer' => $customer,
				'status_icon' => $icon,
				'status' => $status,
				'status_class' => $projectstatus,
				'customer_id' => $project[ 'customer_id' ],
				'members' => $members,
				'milestones' => $milestones,
			);
		};
		echo json_encode( $data_projects );
	}

	function project( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$settings = $this->Settings_Model->get_settings_ciuis();
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$projectmembers = $this->Projects_Model->get_members( $id );
		$project_logs = $this->Logs_Model->project_logs( $id );
		$totaltasks = $this->Report_Model->totalprojecttasks( $id );
		$opentasks = $this->Report_Model->openprojecttasks( $id );
		$completetasks = $this->Report_Model->completeprojecttasks( $id );
		$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
		if ( $project[ 'customercompany' ] === NULL ) {
			$customer = $project[ 'namesurname' ];
		} else $customer = $project[ 'customercompany' ];
		$enddate = $project[ 'deadline' ];
		$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$end_date = new DateTime( "$enddate", new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$interval = $current_date->diff( $end_date );
		$project_left_date = $interval->format( '%a day(s)' );
		if ( date( "Y-m-d" ) > $project[ 'deadline' ] ) {
			$ldt = 'Time\'s up!';
		} else $ldt = $project_left_date;
		switch ( $project[ 'status' ] ) {
			case '1':
				$status_project = lang( 'notstarted' );
				break;
			case '2':
				$status_project = lang( 'started' );
				break;
			case '3':
				$status_project = lang( 'percentage' );
				break;
			case '4':
				$status_project = lang( 'cancelled' );
				break;
			case '5':
				$status_project = lang( 'complete' );
				break;
		};
		if ( in_array( current_user_id, array_column( $projectmembers, 'staff_id' ) ) || !if_admin ) {
			$authorization = "true";
		} else {
			$authorization = 'false';
		};
		if ( $project[ 'invoice_id' ] > 0 ) {
			$billed = lang( 'yes' );
		} else {
			$billed = lang( 'no' );
		}
		$tasks = $this->Tasks_Model->get_project_tasks( $id );
		$data_projecttasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = '';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = 'Project';
					break;
				case 'ticket':
					$relationtype = 'Tıcket';
					break;
				case 'proposal':
					$relationtype = 'Proposal';
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			};
			$data_projecttasks[] = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'relationtype' => $relationtype,
				'status' => $status,
				'status_id' => $task[ 'status_id' ],
				'duedate' => $duedate,
				'startdate' => $startdate,
				'done' => $taskdone,
			);
		};
		$data_projectdetail = array(
			'id' => $project[ 'id' ],
			'name' => $project[ 'name' ],
			'description' => $project[ 'description' ],
			'start' => $project[ 'start_date' ],
			'deadline' => $project[ 'deadline' ],
			'created' => $project[ 'created' ],
			'finished' => $project[ 'finished' ],
			'status' => $status_project,
			'progress' => $progress,
			'totaltasks' => $totaltasks,
			'opentasks' => $opentasks,
			'completetasks' => $completetasks,
			'customer' => $customer,
			'customer_id' => $project[ 'customer_id' ],
			'ldt' => $ldt,
			'authorization' => $authorization,
			'billed' => $billed,
			'milestones' => $milestones,
			'tasks' => $data_projecttasks,
			'members' => $projectmembers,
			'project_logs' => $project_logs
		);
		echo json_encode( $data_projectdetail );
	}

	function projectmilestones( $id ) {
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			if ( date( "Y-m-d" ) > $milestone[ 'duedate' ] ) {
				$status = 'is-completed';
			}
			if ( date( "Y-m-d" ) < $milestone[ 'duedate' ] ) {
				$status = 'is-future';
			};
			$tasks = $this->Projects_Model->get_all_project_milestones_task( $milestone[ 'id' ] );
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'duedate' => $milestone[ 'duedate' ],
				'description' => $milestone[ 'description' ],
				'order' => $milestone[ 'order' ],
				'due' => $milestone[ 'duedate' ],
				'status' => $status,
				'tasks' => $tasks,
			);
		};
		echo json_encode( $data_milestones );
	}

	function notes() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$notes = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $relation_id, 'relation_type' => $relation_type ) )->result_array();
		$data_projectnotes = array();
		foreach ( $notes as $note ) {
			$data_projectnotes[] = array(
				'id' => $note[ 'id' ],
				'description' => $note[ 'description' ],
				'staffid' => $note[ 'addedfrom' ],
				'staff' => $note[ 'notestaff' ],
				'date' => _adate( $note[ 'created' ] ),
			);
		};
		echo json_encode( $data_projectnotes );


	}

	function projectfiles( $id ) {
		$files = $this->Projects_Model->get_project_files( $id );
		$data_files = array();
		foreach ( $files as $file ) {
			$data_files[] = array(
				'id' => $file[ 'id' ],
				'name' => $file[ 'file_name' ],
			);
		};
		echo json_encode( $data_files );
	}

	function projecttimelogs( $id ) {
		$timelogs = $this->Projects_Model->get_project_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $timelog[ 'task_id' ] );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'status' => $timelog[ 'status' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			}
		};
		echo json_encode( $data_timelogs );
	}

	function tasks() {
		$tasks = $this->Tasks_Model->get_all_tasks();
		$data_tasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = 'done';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = lang( 'project' );
					break;
				case 'ticket':
					$relationtype = lang( 'ticket' );
					break;
				case 'proposal':
					$relationtype = lang( 'proposal' );
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			};
			$data_tasks[] = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'relationtype' => $relationtype,
				'status' => $status,
				'status_id' => $task[ 'status_id' ],
				'duedate' => $duedate,
				'startdate' => $startdate,
				'done' => $taskdone,
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbypriority' ) . '' => $priority,
			);
		};
		echo json_encode( $data_tasks );
	}

	function task( $id ) {
		$task = $this->Tasks_Model->get_task_detail( $id );
		if ( $task[ 'milestone' ] != NULL ) {
			$milestone = $task[ 'milestone' ];
		} else {
			$milestone = lang( 'nomilestone' );
		}
		$settings = $this->Settings_Model->get_settings_ciuis();
		switch ( $task[ 'status_id' ] ) {
			case '1':
				$status = lang( 'open' );
				break;
			case '2':
				$status = lang( 'inprogress' );
				break;
			case '3':
				$status = lang( 'waiting' );
				break;
			case '4':
				$status = lang( 'complete' );
				break;
			case '5':
				$status = lang( 'cancelled' );
				break;
		};
		switch ( $task[ 'priority' ] ) {
			case '1':
				$priority = lang( 'low' );
				break;
			case '2':
				$priority = lang( 'medium' );
				break;
			case '3':
				$priority = lang( 'high' );
				break;
		};
		switch ( $task[ 'public' ] ) {
			case '1':
				$is_Public = true;
				break;
			case '0':
				$is_Public = false;
				break;
		}
		switch ( $task[ 'visible' ] ) {
			case '1':
				$is_visible = true;
				break;
			case '0':
				$is_visible = false;
				break;
		}
		switch ( $task[ 'billable' ] ) {
			case '1':
				$is_billable = true;
				break;
			case '0':
				$is_billable = false;
				break;
		}
		switch ( $task[ 'timer' ] ) {
			case '1':
				$is_timer = true;
				break;
			case '0':
				$is_timer = false;
				break;
		}
		$taskdata = array(
			'id' => $task[ 'id' ],
			'name' => $task[ 'name' ],
			'description' => $task[ 'description' ],
			'staff' => $task[ 'assigner' ],
			'status' => $status,
			'priority' => $priority,
			'priority_id' => $task[ 'priority' ],
			'status_id' => $task[ 'status_id' ],
			'assigned' => $task[ 'assigned' ],
			'duedate' => $task[ 'duedate' ],
			'startdate' => $task[ 'startdate' ],
			'created' => $task[ 'created' ],
			'relation_type' => $task[ 'relation_type' ],
			'relation' => $task[ 'relation' ],
			'milestone' => $task[ 'milestone' ],
			'datefinished' => $task[ 'datefinished' ],
			'hourlyrate' => $task[ 'hourly_rate' ],
			'timer' => $is_timer,
			'public' => $is_Public,
			'visible' => $is_visible,
			'billable' => $is_billable,

		);
		echo json_encode( $taskdata );
	}

	function weekly_incomings() {
		$allsales[] = $this->Report_Model->weekly_incomings();
		for ( $i = 0; $i < count( $allsales ); $i++ ) {
			foreach ( $allsales[ $i ] as $salesc ) {
				$salesday = date( 'l', strtotime( $salesc[ 'date' ] ) );
				$salestotal = $salesc[ 'total' ];
				$data_timelogs = array();
				foreach ( weekdays_git() as $dayc ) {
					if ( $salesday == $dayc ) {
						$total = $salestotal;
					} else $total = 0;
					$data_timelogs[] = array(
						'day' => $dayc,
						'amount' => $total,
						'type' => 'incoming',
					);
				}

			}
		}
		echo json_encode( $data_timelogs );
	}

	function tasktimelogs( $id ) {
		$timelogs = $this->Tasks_Model->get_task_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $id );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'status' => $timelog[ 'status' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			};
		};
		echo json_encode( $data_timelogs );
	}

	function subtasks( $id ) {
		$subtasks = $this->Tasks_Model->get_subtasks( $id );
		echo json_encode( $subtasks );
	}

	function subtaskscomplete( $id ) {
		$subtaskscomplete = $this->Tasks_Model->get_subtaskscomplete( $id );
		echo json_encode( $subtaskscomplete );
	}

	function taskfiles( $id ) {
		$files = $this->Tasks_Model->get_task_files( $id );
		$data_files = array();
		foreach ( $files as $file ) {
			$data_files[] = array(
				'id' => $file[ 'id' ],
				'name' => $file[ 'file_name' ],
			);
		};
		echo json_encode( $data_files );
	}

	function milestones() {
		$milestones = $this->Projects_Model->get_all_milestones();
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'milestone_id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'project_id' => $milestone[ 'project_id' ],
			);
		};
		echo json_encode( $data_milestones );
	}

	function staff() {
		$staffs = $this->Staff_Model->get_all_staff();
		$data_staffs = array();
		foreach ( $staffs as $staff ) {
			$data_staffs[] = array(
				'id' => $staff[ 'id' ],
				'name' => $staff[ 'staffname' ],
				'avatar' => $staff[ 'staffavatar' ],
				'department' => $staff[ 'department' ],
				'phone' => $staff[ 'phone' ],
				'address' => $staff[ 'address' ],
				'email' => $staff[ 'email' ],
				'birthday' => $staff[ 'birthday' ],
				'last_login' => $staff[ 'last_login' ],
				'appointment_availability' => $staff[ 'appointment_availability' ],
			);
		};
		echo json_encode( $data_staffs );
	}

	function departments() {
		$departments = $this->Settings_Model->get_departments();
		$data_departments = array();
		foreach ( $departments as $department ) {
			$data_departments[] = array(
				'id' => $department[ 'id' ],
				'name' => $department[ 'name' ],
			);
		};
		echo json_encode( $data_departments );
	}

	function expenses_by_relation() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$expenses = $this->Expenses_Model->get_all_expenses_by_relation( $relation_type, $relation_id );
		$data_expenses = array();
		foreach ( $expenses as $expense ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$expensedate = _rdate( $expense[ 'date' ] );
					break;
				case 'dd.mm.yy':
					$expensedate = _udate( $expense[ 'date' ] );
					break;
				case 'yy-mm-dd':
					$expensedate = _mdate( $expense[ 'date' ] );
					break;
				case 'dd-mm-yy':
					$expensedate = _cdate( $expense[ 'date' ] );
					break;
				case 'yy/mm/dd':
					$expensedate = _zdate( $expense[ 'date' ] );
					break;
				case 'dd/mm/yy':
					$expensedate = _kdate( $expense[ 'date' ] );
					break;
			};
			if ( $expense[ 'invoice_id' ] == NULL ) {
				$billstatus = lang( 'notbilled' )and $color = 'warning'
				and $billstatus_code = 'false';
			} else $billstatus = lang( 'billed' )and $color = 'success'
			and $billstatus_code = 'true';
			if ( $expense[ 'customer_id' ] != 0 ) {
				$billable = 'true';
			} else {
				$billable = 'false';
			}
			$data_expenses[] = array(
				'id' => $expense[ 'id' ],
				'title' => $expense[ 'title' ],
				'prefix' => lang( 'expenseprefix' ),
				'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'amount' => $expense[ 'amount' ],
				'staff' => $expense[ 'staff' ],
				'category' => $expense[ 'category' ],
				'billstatus' => $billstatus,
				'billstatus_code' => $billstatus_code,
				'color' => $color,
				'billable' => $billable,
				'date' => $expensedate,
			);
		};
		echo json_encode( $data_expenses );
	}

	function expenses() {
		$expenses = $this->Expenses_Model->get_all_expenses();
		$data_expenses = array();
		foreach ( $expenses as $expense ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$expensedate = _rdate( $expense[ 'date' ] );
					break;
				case 'dd.mm.yy':
					$expensedate = _udate( $expense[ 'date' ] );
					break;
				case 'yy-mm-dd':
					$expensedate = _mdate( $expense[ 'date' ] );
					break;
				case 'dd-mm-yy':
					$expensedate = _cdate( $expense[ 'date' ] );
					break;
				case 'yy/mm/dd':
					$expensedate = _zdate( $expense[ 'date' ] );
					break;
				case 'dd/mm/yy':
					$expensedate = _kdate( $expense[ 'date' ] );
					break;
			};
			if ( $expense[ 'invoice_id' ] == NULL ) {
				$billstatus = lang( 'notbilled' )and $color = 'warning';
			} else $billstatus = lang( 'billed' )and $color = 'success';
			if ( $expense[ 'customer_id' ] != 0 ) {
				$billable = 'true';
			} else {
				$billable = 'false';
			}
			$data_expenses[] = array(
				'id' => $expense[ 'id' ],
				'title' => $expense[ 'title' ],
				'prefix' => lang( 'expenseprefix' ),
				'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'amount' => $expense[ 'amount' ],
				'staff' => $expense[ 'staff' ],
				'category' => $expense[ 'category' ],
				'billstatus' => $billstatus,
				'color' => $color,
				'billable' => $billable,
				'date' => $expensedate,
				'' . lang( 'filterbycategory' ) . '' => $expense[ 'category' ],
				'' . lang( 'filterbybillstatus' ) . '' => $billstatus,
			);
		};
		echo json_encode( $data_expenses );
	}

	function expense( $id ) {
		$expense = $this->Expenses_Model->get_expenses( $id );
		$data_expense = array(
			'id' => $expense[ 'id' ],
			'prefix' => lang( 'expenseprefix' ),
			'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
			'title' => $expense[ 'title' ],
			'amount' => $expense[ 'amount' ],
			'date' => $expense[ 'date' ],
			'category' => $expense[ 'category_id' ],
			'customer' => $expense[ 'customer_id' ],
			'account' => $expense[ 'account_id' ],
			'invoice_id' => $expense[ 'invoice_id' ],
			'description' => $expense[ 'description' ],
			'category_name' => $expense[ 'category' ],
			'staff_name' => $expense[ 'staff' ],
			'account_name' => $expense[ 'account' ],
		);
		echo json_encode( $data_expense );
	}

	function expensescategories() {
		$expensescategories = $this->Expenses_Model->get_all_expensecat();
		$data_expensescategories = array();
		foreach ( $expensescategories as $category ) {
			$catid = $category[ 'id' ];
			$amountby = $this->Report_Model->expenses_amount_by_category( $catid );
			if ( $amountby != NULL ) {
				$amtbc = $amountby;
			} else $amtbc = 0;
			$percent = $this->Report_Model->expenses_percent_by_category( $catid );
			$data_expensescategories[] = array(
				'id' => $category[ 'id' ],
				'name' => $category[ 'name' ],
				'description' => $category[ 'description' ],
				'amountby' => $amtbc,
				'percent' => $percent,
			);
		};
		echo json_encode( $data_expensescategories );
	}

	function proposals() {
		$proposals = $this->Proposals_Model->get_all_proposals();
		$data_proposals = array();
		foreach ( $proposals as $proposal ) {
			$pro = $this->Proposals_Model->get_proposals( $proposal[ 'id' ], $proposal[ 'relation_type' ] );
			if ( $pro[ 'relation_type' ] == 'customer' ) {
				if ( $pro[ 'customercompany' ] === NULL ) {
					$customer = $pro[ 'namesurname' ];
				} else $customer = $pro[ 'customercompany' ];
			}
			if ( $pro[ 'relation_type' ] == 'lead' ) {
				$customer = $pro[ 'leadname' ];
			}
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$date = _rdate( $proposal[ 'date' ] );
					$opentill = _rdate( $proposal[ 'opentill' ] );
					break;
				case 'dd.mm.yy':
					$date = _udate( $proposal[ 'date' ] );
					$opentill = _udate( $proposal[ 'opentill' ] );
					break;
				case 'yy-mm-dd':
					$date = _mdate( $proposal[ 'date' ] );
					$opentill = _mdate( $proposal[ 'opentill' ] );
					break;
				case 'dd-mm-yy':
					$date = _cdate( $proposal[ 'date' ] );
					$opentill = _cdate( $proposal[ 'opentill' ] );
					break;
				case 'yy/mm/dd':
					$date = _zdate( $proposal[ 'date' ] );
					$opentill = _zdate( $proposal[ 'opentill' ] );
					break;
				case 'dd/mm/yy':
					$date = _kdate( $proposal[ 'date' ] );
					$opentill = _kdate( $proposal[ 'opentill' ] );
					break;
			};
			switch ( $proposal[ 'status_id' ] ) {
				case '1':
					$status = lang( 'draft' );
					$class = 'proposal-status-accepted';
					break;
				case '2':
					$status = lang( 'sent' );
					$class = 'proposal-status-sent';
					break;
				case '3':
					$status = lang( 'open' );
					$class = 'proposal-status-open';
					break;
				case '4':
					$status = lang( 'revised' );
					$class = 'proposal-status-revised';
					break;
				case '5':
					$status = lang( 'declined' );
					$class = 'proposal-status-declined';
					break;
				case '6':
					$status = lang( 'accepted' );
					$class = 'proposal-status-accepted';
					break;

			};
			$data_proposals[] = array(
				'id' => $proposal[ 'id' ],
				'assigned' => $proposal[ 'assigned' ],
				'prefix' => lang( 'proposalprefix' ),
				'longid' => str_pad( $proposal[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'subject' => $proposal[ 'subject' ],
				'customer' => $customer,
				'relation' => $proposal[ 'relation' ],
				'date' => $date,
				'opentill' => $opentill,
				'status' => $status,
				'status_id' => $proposal[ 'status_id' ],
				'staff' => $proposal[ 'staffmembername' ],
				'staffavatar' => $proposal[ 'staffavatar' ],
				'total' => $proposal[ 'total' ],
				'class' => $class,
				'relation_type' => $proposal[ 'relation_type' ],
				'' . lang( 'relationtype' ) . '' => $proposal[ 'relation_type' ],
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
				'' . lang( 'filterbyassigned' ) . '' => $proposal[ 'staffmembername' ],
			);
		};
		echo json_encode( $data_proposals );
	}

	function proposal( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$comments = $this->db->get_where( 'comments', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
		if ( $rel_type == 'customer' ) {
			$customer_id = $proposal[ 'relation' ];
			$lead_id = '';
			$proposal_type = false;
		} else {
			$lead_id = $proposal[ 'relation' ];
			$customer_id = '';
			$proposal_type = true;
		}
		if ( $proposal[ 'comment' ] != 0 ) {
			$comment = true;
		} else {
			$comment = false;
		}
		switch ( $proposal[ 'status_id' ] ) {
			case '1':
				$status = lang( 'draft' );
				break;
			case '2':
				$status = lang( 'sent' );
				break;
			case '3':
				$status = lang( 'open' );
				break;
			case '4':
				$status = lang( 'revised' );
				break;
			case '5':
				$status = lang( 'declined' );
				break;
			case '6':
				$status = lang( 'accepted' );
				break;

		};
		$proposal_details = array(
			'id' => $proposal[ 'id' ],
			'token' => $proposal[ 'token' ],
			'long_id' => '' . lang( 'proposalprefix' ) . '-' . str_pad( $proposal[ 'id' ], 6, '0', STR_PAD_LEFT ) . '',
			'subject' => $proposal[ 'subject' ],
			'content' => $proposal[ 'content' ],
			'comment' => $comment,
			'sub_total' => $proposal[ 'sub_total' ],
			'total_discount' => $proposal[ 'total_discount' ],
			'total_tax' => $proposal[ 'total_tax' ],
			'total' => $proposal[ 'total' ],
			'customer' => $customer_id,
			'lead' => $lead_id,
			'proposal_type' => $proposal_type,
			'created' => $proposal[ 'created' ],
			'date' => $proposal[ 'date' ],
			'opentill' => $proposal[ 'opentill' ],
			'status' => $proposal[ 'status_id' ],
			'assigned' => $proposal[ 'assigned' ],
			'content' => $proposal[ 'content' ],
			'invoice_id' => $proposal[ 'invoice_id' ],
			'status_name' => $status,
			'items' => $items,
			'comments' => $comments,
		);
		echo json_encode( $proposal_details );
	}

	function invoices() {
		$invoices = $this->Invoices_Model->get_all_invoices();
		$data_invoices = array();
		foreach ( $invoices as $invoice ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$created = _rdate( $invoice[ 'created' ] );
					$duedate = _rdate( $invoice[ 'duedate' ] );
					break;
				case 'dd.mm.yy':
					$created = _udate( $invoice[ 'created' ] );
					$duedate = _udate( $invoice[ 'duedate' ] );
					break;
				case 'yy-mm-dd':
					$created = _mdate( $invoice[ 'created' ] );
					$duedate = _mdate( $invoice[ 'duedate' ] );
					break;
				case 'dd-mm-yy':
					$created = _cdate( $invoice[ 'created' ] );
					$duedate = _cdate( $invoice[ 'duedate' ] );
					break;
				case 'yy/mm/dd':
					$created = _zdate( $invoice[ 'created' ] );
					$duedate = _zdate( $invoice[ 'duedate' ] );
					break;
				case 'dd/mm/yy':
					$created = _kdate( $invoice[ 'created' ] );
					$duedate = _kdate( $invoice[ 'duedate' ] );
					break;
			};
			if ( $invoice[ 'duedate' ] == 0000 - 00 - 00 ) {
				$realduedate = 'No Due Date';
			} else $realduedate = $duedate;
			$totalx = $invoice[ 'total' ];
			$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(invoice_id =' . $invoice[ 'id' ] . ') ' );
			$paytotal = $this->db->get();
			$balance = $totalx - $paytotal->row()->amount;
			if ( $balance > 0 ) {
				$invoicestatus = '';
			} else $invoicestatus = lang( 'paidinv' );
			$color = 'success';;
			if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 && $invoice[ 'status_id' ] == 3 ) {
				$invoicestatus = lang( 'partial' );
				$color = 'warning';
			} else {
				if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 ) {
					$invoicestatus = lang( 'partial' );
					$color = 'warning';
				}
				if ( $invoice[ 'status_id' ] == 3 ) {
					$invoicestatus = lang( 'unpaid' );
					$color = 'danger';
				}
			}
			if ( $invoice[ 'status_id' ] == 1 ) {
				$invoicestatus = lang( 'draft' );
				$color = 'muted';
			}
			if ( $invoice[ 'status_id' ] == 4 ) {
				$invoicestatus = lang( 'cancelled' );
				$color = 'danger';
			}
			if ( $invoice[ 'type' ] == 1 ) {
				$customer = $invoice[ 'individual' ];
			} else $customer = $invoice[ 'customercompany' ];
			$data_invoices[] = array(
				'id' => $invoice[ 'id' ],
				'prefix' => lang( 'invoiceprefix' ),
				'longid' => str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'created' => $created,
				'duedate' => $realduedate,
				'customer' => $customer,
				'customer_id' => $invoice[ 'customer_id' ],
				'staff_id' => $invoice[ 'staff_id' ],
				'total' => $invoice[ 'total' ],
				'status' => $invoicestatus,
				'color' => $color,
				'' . lang( 'filterbystatus' ) . '' => $invoicestatus,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
			);
		};
		echo json_encode( $data_invoices );
	}

	function invoice( $id ) {
		$invoice = $this->Invoices_Model->get_invoices( $id );
		$fatop = $this->Invoices_Model->get_items_invoices( $id );
		$tadtu = $this->Invoices_Model->get_paid_invoices( $id );
		$total = $invoice[ 'total' ];
		$today = time();
		$duedate = strtotime( $invoice[ 'duedate' ] ); // or your date as well
		$created = strtotime( $invoice[ 'created' ] );
		$paymentday = $duedate - $created; // Bunun sonucu 14 gün olcak
		$paymentx = $today - $created;
		$datepaymentnet = $paymentday - $paymentx;
		if ( $invoice[ 'duedate' ] == 0 ) {
			$duedate_text = 'No Due Date';
		} else {
			if ( $datepaymentnet < 0 ) {
				$duedate_text = lang( 'overdue' );
				$duedate_text = '' . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' days';

			} else {
				$duedate_text = lang( 'payableafter' ) . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' ' . lang( 'day' ) . '';

			}
		}
		if ( $invoice[ 'datesend' ] == 0 ) {
			$mail_status = lang( 'notyetbeensent' );
		} else $mail_status = _adate( $invoice[ 'datesend' ] );
		$kalan = $total - $tadtu->row()->amount;
		$net_balance = $kalan;
		if ( $tadtu->row()->amount < $total && $tadtu->row()->amount > 0 ) {
			$partial_is = true;
		} else $partial_is = false;
		$payments = $this->db->select( '*,accounts.name as accountname,payments.id as id ' )->join( 'accounts', 'payments.account_id = accounts.id', 'left' )->get_where( 'payments', array( 'invoice_id' => $id ) )->result_array();
		$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();

		if ( $invoice[ 'type' ] == 1 ) {
			$customer = $invoice[ 'individual' ];
		} else $customer = $invoice[ 'customercompany' ];

		$properties = array(
			'invoice_id' => '' . lang( 'invoiceprefix' ) . '-' . str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ) . '',
			'customer' => $customer,
			'customer_address' => $invoice[ 'customeraddress' ],
			'customer_phone' => $invoice[ 'phone' ],
			'invoice_staff' => $invoice[ 'staffmembername' ],

		);

		$invoice_details = array(
			'id' => $invoice[ 'id' ],
			'sub_total' => $invoice[ 'sub_total' ],
			'total_discount' => $invoice[ 'total_discount' ],
			'total_tax' => $invoice[ 'total_tax' ],
			'total' => $invoice[ 'total' ],
			'no' => $invoice[ 'no' ],
			'serie' => $invoice[ 'serie' ],
			'created' => date( DATE_ISO8601, strtotime( $invoice[ 'created' ] ) ),
			'duedate' => $invoice[ 'duedate' ],
			'customer' => $invoice[ 'customer_id' ],
			'datepayment' => $invoice[ 'datepayment' ],
			'duenote' => $invoice[ 'duenote' ],
			'status_id' => $invoice[ 'status_id' ],
			'duedate_text' => $duedate_text,
			'mail_status' => $mail_status,
			'balance' => $net_balance,
			'partial_is' => $partial_is,
			'items' => $items,
			'payments' => $payments,
			// Recurring Invoice
			'recurring_endDate' => $invoice[ 'recurring_endDate' ] ? date( DATE_ISO8601, strtotime( $invoice[ 'recurring_endDate' ] ) ) : '' ,
			'recurring_id' => $invoice[ 'recurring_id' ],
			'recurring_status' => $invoice[ 'recurring_status' ] == 0 ? true : false,
			'recurring_period' => $invoice[ 'recurring_period' ],
			'recurring_type' => $invoice[ 'recurring_type' ] ? $invoice[ 'recurring_type' ] : 0,
			// END Recurring Invoice
			'payments' => $payments,
			'properties' => $properties

		);
		echo json_encode( $invoice_details );
	}

	function dueinvoices() {
		$dueinvoices = $this->Invoices_Model->dueinvoices();
		$data_dueinvoices = array();
		foreach ( $dueinvoices as $invoice ) {
			if ( $invoice[ 'type' ] == 1 ) {
				$customer = $invoice[ 'individual' ];
			} else $customer = $invoice[ 'customercompany' ];
			$data_dueinvoices[] = array(
				'id' => $invoice[ 'id' ],
				'total' => $invoice[ 'total' ],
				'customer' => $customer,
			);
		};
		echo json_encode( $data_dueinvoices );
	}

	function overdueinvoices() {
		$overdueinvoices = $this->Invoices_Model->overdueinvoices();
		$data_overdueinvoices = array();
		foreach ( $overdueinvoices as $invoice ) {
			if ( $invoice[ 'type' ] == 1 ) {
				$customer = $invoice[ 'individual' ];
			} else $customer = $invoice[ 'customercompany' ];
			$today = time();
			$duedate = strtotime( $invoice[ 'duedate' ] ); // or your date as well
			$created = strtotime( $invoice[ 'created' ] );
			$paymentday = $duedate - $created; // Calculate days left.
			$paymentx = $today - $created;
			$datepaymentnet = $paymentday - $paymentx;
			if ( $datepaymentnet < 0 ) {
				$status = '' . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' days';
			};
			$data_overdueinvoices[] = array(
				'id' => $invoice[ 'id' ],
				'total' => $invoice[ 'total' ],
				'customer' => $customer,
				'status' => $status,
			);
		};
		echo json_encode( $data_overdueinvoices );
	}

	function reminders() {
		$reminders = $this->Trivia_Model->get_reminders();
		$data_reminders = array();
		foreach ( $reminders as $reminder ) {
			switch ( $reminder[ 'relation_type' ] ) {
				case 'event':
					$remindertitle = lang( 'eventreminder' );
					break;
				case 'lead':
					$remindertitle = lang( 'leadreminder' );
					break;
				case 'customer':
					$remindertitle = lang( 'customerreminder' );
					break;
				case 'invoice':
					$remindertitle = lang( 'invoicereminder' );
					break;
				case 'expense':
					$remindertitle = lang( 'expensereminder' );
					break;
				case 'ticket':
					$remindertitle = lang( 'ticketreminder' );
					break;
				case 'proposal':
					$remindertitle = lang( 'proposalreminder' );
					break;
			};
			$data_reminders[] = array(
				'id' => $reminder[ 'id' ],
				'title' => $remindertitle,
				'date' => date( DATE_ISO8601, strtotime( $reminder[ 'date' ] ) ),
				'description' => $reminder[ 'description' ],
				'creator' => $reminder[ 'remindercreator' ],
			);
		};
		echo json_encode( $data_reminders );
	}

	function reminders_by_type() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$reminders = $this->db->select( '*,staff.staffname as staff,staff.staffavatar as avatar,reminders.id as id ' )->join( 'staff', 'reminders.staff_id = staff.id', 'left' )->get_where( 'reminders', array( 'relation' => $relation_id, 'relation_type' => $relation_type ) )->result_array();
		$data_reminders = array();
		foreach ( $reminders as $reminder ) {
			$data_reminders[] = array(
				'id' => $reminder[ 'id' ],
				'date' => _adate( $reminder[ 'date' ] ),
				'description' => $reminder[ 'description' ],
				'creator' => $reminder[ 'staff' ],
				'avatar' => base_url( 'uploads/images/' . $reminder[ 'avatar' ] . '' ),
			);
		};
		echo json_encode( $data_reminders );


	}

	function notifications() {
		$notifications = $this->Notifications_Model->get_all_notifications();
		$data_notifications = array();
		foreach ( $notifications as $notification ) {
			switch ( $notification[ 'markread' ] ) {
				case 0:
					$read = true;
					break;
				case 1:
					$read = false;
					break;
			};
			$data_notifications[] = array(
				'id' => $notification[ 'notifyid' ],
				'target' => $notification[ 'target' ],
				'date' => tes_ciuis( $notification[ 'date' ] ),
				'detail' => $notification[ 'detail' ],
				'avatar' => $notification[ 'perres' ],
				'read' => $read,
			);
		};
		echo json_encode( $data_notifications );
	}

	function tickets() {
		$tickets = $this->Tickets_Model->get_all_tickets();
		$data_tickets = array();
		foreach ( $tickets as $ticket ) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			$data_tickets[] = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'message' => $ticket[ 'message' ],
				'staff_id' => $ticket[ 'staff_id' ],
				'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
				'priority' => $priority,
				'priority_id' => $ticket[ 'priority' ],
				'lastreply' => date( DATE_ISO8601, strtotime( $ticket[ 'lastreply' ] ) ),
				'status_id' => $ticket[ 'status_id' ],
				'customer_id' => $ticket[ 'customer_id' ],
			);
		};
		echo json_encode( $data_tickets );
	}

	function ticket( $id ) {
		$ticket = $this->Tickets_Model->get_tickets( $id );
		switch ( $ticket[ 'priority' ] ) {
			case '1':
				$priority = lang( 'low' );
				break;
			case '2':
				$priority = lang( 'medium' );
				break;
			case '3':
				$priority = lang( 'high' );
				break;
		};
		switch ( $ticket[ 'status_id' ] ) {
			case '1':
				$status = lang( 'open' );
				break;
			case '2':
				$status = lang( 'inprogress' );
				break;
			case '3':
				$status = lang( 'answered' );
				break;
			case '4':
				$status = lang( 'closed' );
				break;
		};
		if ( $ticket[ 'type' ] == 0 ) {
			$customer = $ticket[ 'company' ];
		} else $customer = $ticket[ 'namesurname' ];
		$data_ticketdetails = array(
			'id' => $ticket[ 'id' ],
			'subject' => $ticket[ 'subject' ],
			'message' => $ticket[ 'message' ],
			'staff_id' => $ticket[ 'staff_id' ],
			'contact_id' => $ticket[ 'contact_id' ],
			'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
			'priority' => $priority,
			'priority_id' => $ticket[ 'priority' ],
			'lastreply' => $ticket[ 'lastreply' ],
			'status' => $status,
			'status_id' => $ticket[ 'status_id' ],
			'customer_id' => $ticket[ 'customer_id' ],
			'department' => $ticket[ 'department' ],
			'opened_date' => _adate( $ticket[ 'date' ] ),
			'last_reply_date' => _adate( $ticket[ 'lastreply' ] ),
			'attachment' => $ticket[ 'attachment' ],
			'customer' => $customer,
			'assigned_staff_name' => $ticket[ 'staffmembername' ],
			'replies' => $this->db->get_where( 'ticketreplies', array( 'ticket_id' => $id ) )->result_array(),
		);
		echo json_encode( $data_ticketdetails );
	}

	function newtickets() {
		$newtickets = $this->Tickets_Model->get_all_open_tickets();
		$data_newtickets = array();
		foreach ( $newtickets as $ticket ) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			$data_newtickets[] = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'contactsurname' => $ticket[ 'contactsurname' ],
				'contactname' => $ticket[ 'contactname' ],
				'priority' => $priority,
			);
		};
		echo json_encode( $data_newtickets );
	}

	function transactions() {
		$transactions = $this->Payments_Model->todaypayments();
		$data_transactions = array();
		foreach ( $transactions as $transaction ) {
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$type = 'paymenttoday';
					break;
				case '1':
					$type = 'expensetoday';
					break;
			};
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$icon = 'ion-log-in';
					break;
				case '1':
					$icon = 'ion-log-out';
					break;
			};
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$title = lang( 'paymentistoday' );
					break;
				case '1':
					$title = lang( 'expensetoday' );
					break;
			};
			$data_transactions[] = array(
				'id' => $transaction[ 'id' ],
				'amount' => $transaction[ 'amount' ],
				'type' => $type,
				'title' => $title,
				'icon' => $icon,
			);
		};
		echo json_encode( $data_transactions );
	}

	function logs() {
		$logs = $this->Logs_Model->panel_last_logs();
		$data_logs = array();
		foreach ( $logs as $log ) {
			$data_logs[] = array(
				'logdate' => date( DATE_ISO8601, strtotime( $log[ 'date' ] ) ),
				'date' => tes_ciuis( $log[ 'date' ] ),
				'detail' => $log[ 'detail' ],
				'customer_id' => $log[ 'customer_id' ],
				'project_id' => $log[ 'project_id' ],
				'staff_id' => $log[ 'staff_id' ],
			);
		};
		echo json_encode( $data_logs );
	}

	function contacts() {
		$contacts = $this->Contacts_Model->get_all_contacts();
		$data_contacts = array();
		foreach ( $contacts as $contact ) {
			$data_contacts[] = array(
				'id' => $contact[ 'id' ],
				'customer_id' => $contact[ 'customer_id' ],
				'name' => '' . $contact[ 'name' ] . ' ' . $contact[ 'surname' ] . '',
				'email' => $contact[ 'email' ],
				'phone' => $contact[ 'phone' ],
				'username' => $contact[ 'username' ],
				'address' => $contact[ 'address' ],
			);
		};
		echo json_encode( $data_contacts );
	}

	function customers() {
		$customers = $this->Customers_Model->get_all_customers();
		$data_customers = array();
		foreach ( $customers as $customer ) {
			switch ( $customer[ 'type' ] ) {
				case '0':
					$name = $customer[ 'company' ];
					$type = lang( 'corporatecustomers' );
					break;
				case '1':
					$name = $customer[ 'namesurname' ];
					$type = lang( 'individual' );
					break;
			};
			$this->db->select_sum( 'total' )->from( 'invoices' )->where( '(status_id = 3 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$total_unpaid_invoice_amount = $this->db->get()->row()->total;
			$this->db->select_sum( 'total' )->from( 'invoices' )->where( '(status_id = 2 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$total_paid_invoice_amount = $this->db->get()->row()->total;
			$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(transactiontype = 0 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$total_paid_amount = $this->db->get()->row()->amount;
			$contacts = $this->Contacts_Model->get_customer_contacts( $customer[ 'id' ] );
			$data_customers[] = array(
				'id' => $customer[ 'id' ],
				'customer_id' => $customer[ 'id' ],
				'name' => $name,
				'address' => $customer[ 'address' ],
				'email' => $customer[ 'email' ],
				'phone' => $customer[ 'phone' ],
				'balance' => $total_unpaid_invoice_amount - $total_paid_amount + $total_paid_invoice_amount,
				'contacts' => $contacts,
				'' . lang( 'filterbytype' ) . '' => $type,
				'' . lang( 'filterbycountry' ) . '' => $customer[ 'country' ],
			);
		};
		echo json_encode( $data_customers );
	}

	function customer( $id ) {
		$customer = $this->Customers_Model->get_customers( $id );
		$contacts = $this->Contacts_Model->get_customer_contacts( $id );
		$this->db->select_sum( 'total' );
		$this->db->from( 'invoices' );
		$this->db->where( '(status_id = 2 AND customer_id = ' . $customer[ 'id' ] . ') ' );
		$netrevenue = $this->db->get();
		$this->db->select_sum( 'total' );
		$this->db->from( 'invoices' );
		$this->db->where( '(status_id != 1 AND customer_id = ' . $customer[ 'id' ] . ') ' );
		$grossrevenue = $this->db->get();
		$data_customerdetail = array(
			'id' => $customer[ 'id' ],
			'type' => $customer[ 'type' ],
			'created' => $customer[ 'created' ],
			'staff_id' => $customer[ 'staff_id' ],
			'company' => $customer[ 'company' ],
			'namesurname' => $customer[ 'namesurname' ],
			'taxoffice' => $customer[ 'taxoffice' ],
			'taxnumber' => $customer[ 'taxnumber' ],
			'ssn' => $customer[ 'ssn' ],
			'executive' => $customer[ 'executive' ],
			'address' => $customer[ 'address' ],
			'zipcode' => $customer[ 'zipcode' ],
			'country_id' => $customer[ 'country_id' ],
			'state' => $customer[ 'state' ],
			'city' => $customer[ 'city' ],
			'town' => $customer[ 'town' ],
			'phone' => $customer[ 'phone' ],
			'fax' => $customer[ 'fax' ],
			'email' => $customer[ 'email' ],
			'web' => $customer[ 'web' ],
			'risk' => intval( $customer[ 'risk' ] ),
			'netrevenue' => $netrevenue->row()->total,
			'grossrevenue' => $grossrevenue->row()->total,
			'country' => $customer[ 'country' ],
			'contacts' => $contacts,
			'chart_data' => $this->Report_Model->customer_annual_sales_chart( $id ),
		);
		echo json_encode( $data_customerdetail );
	}

	function countries() {
		$countries = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$data_countries = array();
		foreach ( $countries as $country ) {
			$data_countries[] = array(
				'id' => $country[ 'id' ],
				'shortname' => $country[ 'shortname' ],
				'isocode' => $country[ 'isocode' ],
			);
		};
		echo json_encode( $data_countries );
	}

	function events() {
		$events = $this->Events_Model->get_all_events();
		$data_events = array();
		foreach ( $events as $event ) {
			if ( $event[ 'end' ] < date( " Y-m-d h:i:sa" ) ) {
				$status = 'past';
			} else {
				$status = 'next';
			};
			$data_events[] = array(
				'day' => date( 'D', strtotime( $event[ 'start' ] ) ),
				'aday' => _dDay( $event[ 'start' ] ),
				'start' => _adate( $event[ 'start' ] ),
				'start_iso_date' => date( DATE_ISO8601, strtotime( $event[ 'start' ] ) ),
				'start_date' => $event[ 'start' ],
				'end_date' => $event[ 'end' ],
				'detail' => $event[ 'detail' ],
				'title' => $event[ 'title' ],
				'staff' => $event[ 'staff' ],
				'status' => $status,
				'date' => date( DATE_ISO8601, strtotime( $event[ 'start' ] ) ),
			);
		};
		echo json_encode( $data_events );
	}

	function appointments() {
		$appointments = $this->Events_Model->get_all_appointments();
		$data_appointments = array();
		foreach ( $appointments as $appointment ) {
			if ( $appointment[ 'end' ] < date( " Y-m-d h:i:sa" ) ) {
				$status = 'past';
			} else {
				$status = 'next';
			};
			$data_appointments[] = array(
				'id' => $appointment[ 'id' ],
				'day' => date( 'D', strtotime( $appointment[ 'start' ] ) ),
				'aday' => _dDay( $appointment[ 'start' ] ),
				'start' => _adate( $appointment[ 'start' ] ),
				'start_iso_date' => date( DATE_ISO8601, strtotime( $appointment[ 'start' ] ) ),
				'start_date' => $appointment[ 'start' ],
				'end_date' => $appointment[ 'end' ],
				'detail' => $appointment[ 'note' ],
				'title' =>  ''.$message = sprintf( lang( 'appointment_for' ), $appointment[ 'contact_name' ] ).'',
				'staff' => $appointment[ 'staff' ],
				'contact' => ''.$appointment[ 'contact_name' ].' '.$appointment[ 'contact_surname' ].'',
				'status_class' => $status,
				'status' => $appointment['status'],
				'date' => date( DATE_ISO8601, strtotime( $appointment[ 'start' ] ) ),
			);
		};
		echo json_encode( $data_appointments );
	}
	
	function confirmed_appointments() {
		$appointments = $this->Events_Model->get_all_confirmed_appointments();
		$data_appointments = array();
		foreach ( $appointments as $appointment ) {
			if ( $appointment[ 'end' ] < date( " Y-m-d h:i:sa" ) ) {
				$status = 'past';
			} else {
				$status = 'next';
			};
			$data_appointments[] = array(
				'id' => $appointment[ 'id' ],
				'day' => date( 'D', strtotime( $appointment[ 'start' ] ) ),
				'aday' => _dDay( $appointment[ 'start' ] ),
				'start' => _adate( $appointment[ 'start' ] ),
				'start_date' => $appointment[ 'start' ],
				'end_date' => $appointment[ 'end' ],
				'detail' => $appointment[ 'note' ],
				'title' =>  ''.$message = sprintf( lang( 'appointment_for' ), $appointment[ 'contact_name' ] ).'',
				'staff' => $appointment[ 'staff' ],
				'contact' => ''.$appointment[ 'contact_name' ].' '.$appointment[ 'contact_surname' ].'',
				'status_class' => $status,
				'status' => $appointment['status'],
				'date' => date( DATE_ISO8601, strtotime( $appointment[ 'start' ] ) ),
			);
		};
		echo json_encode( $data_appointments );
	}

	function todos() {
		$todos = $this->Trivia_Model->get_todos();
		$data_todo = array();
		foreach ( $todos as $todo ) {
			$data_todo[] = array(
				'id' => $todo[ 'id' ],
				'date' => date( DATE_ISO8601, strtotime( $todo[ 'date' ] ) ),
				'description' => $todo[ 'description' ],
			);
		};
		echo json_encode( $data_todo );
	}

	function donetodos() {
		$donetodos = $this->Trivia_Model->get_done_todos();
		$data_donetodos = array();
		foreach ( $donetodos as $donetodo ) {
			$data_donetodos[] = array(
				'id' => $donetodo[ 'id' ],
				'date' => date( DATE_ISO8601, strtotime( $donetodo[ 'date' ] ) ),
				'description' => $donetodo[ 'description' ],
			);
		};
		echo json_encode( $data_donetodos );
	}

	function accounts() {
		$accounts = $this->Accounts_Model->get_all_accounts();
		$data_account = array();
		foreach ( $accounts as $account ) {
			switch ( $account[ 'type' ] ) {
				case '0':
					$icon = 'mdi mdi-balance-wallet';
					break;
				case '1':
					$icon = 'mdi mdi-balance';
					break;
			};
			switch ( $account[ 'status_id' ] ) {
				case '0':
					$status = lang( 'accuntactive' );
					break;
				case '0':
					$status = lang( 'accuntnotactive' );
					break;
			};
			$data_account[] = array(
				'id' => $account[ 'id' ],
				'name' => $account[ 'name' ],
				'amount' => $data = $amountby = $this->Report_Model->get_account_amount( $account[ 'id' ] ),
				'icon' => $icon,
				'status' => $status,
			);
		};
		echo json_encode( $data_account );
	}

	function account( $id ) {
		$account = $this->Accounts_Model->get_accounts( $id );
		$payments = $this->db->select( '*' )->order_by( 'id', 'desc' )->get_where( 'payments', array( 'account_id' => $id ) )->result_array();
		$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(account_id = ' . $id . ' and transactiontype = 0)' );
		$account_incomings_sum = $this->db->get()->row()->amount;
		$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(account_id = ' . $id . ' and transactiontype = 1)' );
		$account_outgoings_sum = $this->db->get()->row()->amount;
		$account_sum = ( $account_incomings_sum - $account_outgoings_sum );
		if ( !empty( $account_sum ) ) {
			$account_total = $account_incomings_sum - $account_outgoings_sum;
		} else {
			$account_total = 0;
		}
		switch ( $account[ 'status_id' ] ) {
			case '1':
				$is_status = false;
				break;
			case '0':
				$is_status = true;
				break;
		}

		$payments_data = array();
		foreach ( $payments as $payment ) {
			$payments_data[] = array(
				'id' => $payment[ 'id' ],
				'transactiontype' => $payment[ 'transactiontype' ],
				'invoice_id' => $payment[ 'invoice_id' ],
				'expense_id' => $payment[ 'expense_id' ],
				'customer_id' => $payment[ 'customer_id' ],
				'amount' => $payment[ 'amount' ],
				'account_id' => $payment[ 'account_id' ],
				'date' => date( DATE_ISO8601, strtotime( $payment[ 'date' ] ) ),
				'attachment' => $payment[ 'attachment' ],
				'staff_id' => $payment[ 'staff_id' ],
			);
		};

		$data_account = array(
			'id' => $account[ 'id' ],
			'name' => $account[ 'name' ],
			'type' => $account[ 'type' ],
			'bankname' => $account[ 'bankname' ],
			'branchbank' => $account[ 'branchbank' ],
			'account' => $account[ 'account' ],
			'iban' => $account[ 'iban' ],
			'account_total' => $account_total,
			'status' => $is_status,
			'payments' => $payments_data,
		);
		echo json_encode( $data_account );
	}

	function leads() {
		if ( !if_admin ) {
			$leads = $this->Leads_Model->get_all_leads_for_admin();
		} else {
			$leads = $this->Leads_Model->get_all_leads();
		};
		$data_leads = array();
		foreach ( $leads as $lead ) {
			$data_leads[] = array(
				'id' => $lead[ 'id' ],
				'name' => $lead[ 'leadname' ],
				'company' => $lead[ 'company' ],
				'phone' => $lead[ 'leadphone' ],
				'color' => $lead[ 'color' ],
				'status' => $lead[ 'status' ],
				'statusname' => $lead[ 'statusname' ],
				'source' => $lead[ 'source' ],
				'sourcename' => $lead[ 'sourcename' ],
				'assigned' => $lead[ 'leadassigned' ],
				'avatar' => $lead[ 'assignedavatar' ],
				'staff' => $lead[ 'staff_id' ],
				'createddate' => $lead[ 'created' ],
				'' . lang( 'filterbystatus' ) . '' => $lead[ 'statusname' ],
				'' . lang( 'filterbysource' ) . '' => $lead[ 'sourcename' ],
			);
		};
		echo json_encode( $data_leads );
	}

	function leads_by_leadsource_leadpage() {
		echo json_encode( $this->Report_Model->leads_by_leadsource_leadpage() );
	}

	function lead( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		switch ( $lead[ 'public' ] ) {
			case '0':
				$is_public = false;
				break;
			case '1':
				$is_public = true;
				break;
		}
		switch ( $lead[ 'type' ] ) {
			case '0':
				$is_individual = false;
				break;
			case '1':
				$is_individual = true;
				break;
		}
		$data_lead = array(
			'id' => $lead[ 'id' ],
			'type' => $lead[ 'type' ],
			'name' => $lead[ 'leadname' ],
			'title' => $lead[ 'title' ],
			'company' => $lead[ 'company' ],
			'description' => $lead[ 'description' ],
			'country_id' => $lead[ 'country_id' ],
			'country' => $lead[ 'leadcountry' ],
			'zip' => $lead[ 'zip' ],
			'city' => $lead[ 'city' ],
			'state' => $lead[ 'state' ],
			'email' => $lead[ 'leadmail' ],
			'address' => $lead[ 'address' ],
			'website' => $lead[ 'website' ],
			'phone' => $lead[ 'leadphone' ],
			'assigned' => $lead[ 'leadassigned' ],
			'assigned_id' => $lead[ 'assigned_id' ],
			'created' => $lead[ 'created' ],
			'status_id' => $lead[ 'status' ],
			'status' => $lead[ 'statusname' ],
			'source_id' => $lead[ 'source' ],
			'source' => $lead[ 'sourcename' ],
			'lastcontact' => $lead[ 'lastcontact' ],
			'dateassigned' => $lead[ 'dateassigned' ],
			'staff_id' => $lead[ 'staff_id' ],
			'dateconverted' => $lead[ 'dateconverted' ],
			'lost' => $lead[ 'lost' ],
			'junk' => $lead[ 'junk' ],
			'public' => $is_public,
			'type' => $is_individual,
		);
		echo json_encode( $data_lead );
	}

	function leadstatuses() {
		$leadstatuses = $this->Leads_Model->get_leads_status();
		echo json_encode( $leadstatuses );
	}

	function leadsources() {
		$leadsources = $this->Leads_Model->get_leads_sources();
		echo json_encode( $leadsources );
	}

	function products() {
		$products = $this->Products_Model->get_all_products();
		$settings = $this->Settings_Model->get_settings_ciuis();
		$data_products = array();
		foreach ( $products as $product ) {
			$data_products[] = array(
				'product_id' => $product[ 'id' ],
				'code' => $product[ 'code' ],
				'name' => $product[ 'productname' ],
				'description' => $product[ 'description' ],
				'price' => $product[ 'sale_price' ],
				'tax' => $product[ 'vat' ],
			);
		};
		echo json_encode( $data_products );
	}

	function product( $id ) {
		$product = $this->Products_Model->get_products( $id );
		$total_product_sales = $this->db->from( 'items' )->where( 'product_id = ' . $product[ 'id' ] . '' )->get()->num_rows();
		$pricepurchase = $total_product_sales * $product[ 'purchase_price' ];
		$pricesales = $total_product_sales * $product[ 'sale_price' ];
		$netearnings = $pricesales - $pricepurchase;
		$data_product = array(
			'id' => $product[ 'id' ],
			'code' => $product[ 'code' ],
			'productname' => $product[ 'productname' ],
			'description' => $product[ 'description' ],
			'productimage' => $product[ 'productimage' ],
			'purchase_price' => $product[ 'purchase_price' ],
			'sale_price' => $product[ 'sale_price' ],
			'stock' => $product[ 'stock' ],
			'vat' => $product[ 'vat' ],
			'status_id' => $product[ 'status_id' ],
			'total_sales' => $total_product_sales,
			'net_earning' => $netearnings,
		);
		echo json_encode( $data_product );
	}

}