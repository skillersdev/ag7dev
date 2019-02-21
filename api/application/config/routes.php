<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ****************************************************************** API CODE ROUTE STARTS HERE - AUG 10, 2017******************************************************************

$route['api'] = 'Api_controller/index';
$route['api/login'] = 'Api_controller/gems_admin_login';

//sidebar mennu
$route['api/menu'] = 'Api_controller/gems_fetch_sidebar_menu_master';
$route['api/menumodule'] = 'Api_controller/gems_fetch_sidebar_menu_module_list';

$route['api/module/getmodulebypath'] = 'Api_controller/gems_get_module_by_path';
$route['api/securityaccess/getsecurityaccess'] = 'Api_controller/gems_get_security_access';

$route['api/securityaccess/getsecurityaccessbymodule'] = 'Api_controller/gems_get_security_access_by_moduleid';

$route['api/getvillagelist'] = 'Api_controller/get_village_master_list';
$route['api/getdistrictlist'] = 'Api_controller/get_district_master_list';
$route['api/getchurchplace'] = 'Api_controller/get_church_place_master_list';
$route['api/getupdateddistrictlist'] = 'Api_controller/get_district_updated_list';
$route['api/panchayatlist'] = 'Api_controller/get_panchayat_updated_list';
$route['api/villagelist'] = 'Api_controller/get_village_updated_list';
$route['api/getdistrict'] = 'Api_controller/get_district';
$route['api/getblock'] = 'Api_controller/get_block';
$route['api/getpanchayat'] = 'Api_controller/get_panchayat';
$route['api/getvillage'] = 'Api_controller/get_village';

//User Role API
$route['api/userrole'] = 'Api_controller/get_user_role_list';
$route['api/userrole/(:num)'] = 'Api_controller/gems_fetch_User_role/$1';
$route['api/createuserrole'] = 'Api_controller/gems_create_user_role';

$route['api/user_role/(:num)'] = 'Api_controller/gems_fetch_user_role_master/$1';
$route['api/user_role/updaterole'] = 'Api_controller/gems_edit_user_role_master';
$route['api/user_role/insertrole'] = 'Api_controller/gems_create_user_role_master';



//admin user fetch
$route['api/user'] = 'Api_controller/get_user_list';
$route['api/create_user'] = 'Api_controller/gems_create_user_master';
$route['api/fetch_user/(:num)'] = 'Api_controller/gems_fetch_User/$1';
$route['api/update_user'] = 'Api_controller/gems_edit_user_master/$1';
$route['api/delete_user/(:num)'] = 'Api_controller/gems_delete_user_master/$1';


// LOGGED IN USER ACCOUNT RELATED FUNCTIONS

// Change password 
$route['api/change_password'] = 'Api_controller/gems_admin_change_password';

// Update profile 
$route['api/profile/(:num)'] = 'Api_controller/get_admin_profile_details/$1';
 
$route['api/update_profile'] = 'Api_controller/gems_admin_profile_update';


// LOGGED IN USER ACCOUNT RELATED FUNCTIONS




// Zone Master 
$route['api/staff_zone/create'] = 'Api_controller/gems_create_zone_master';
$route['api/staff_zone/fetch/(:num)'] = 'Api_controller/gems_fetch_zone_master/$1';
$route['api/staff_zone/edit/(:num)'] = 'Api_controller/gems_edit_zone_master/$1';
$route['api/staff_zone'] = 'Api_controller/get_zone_master_list';
$route['api/staff_zone/delete/(:num)'] = 'Api_controller/gems_delete_zone_master/$1';

$route['api/staff_zone_multiselect'] = 'Api_controller/get_zone_master_filter_list';
$route['api/uploadstaffdocs'] = 'Api_controller/gems_add_staff_docs';
// Zone Master 


// State Master
$route['api/countries'] = 'Api_controller/get_countries_master_list';
$route['api/state/create'] = 'Api_controller/gems_create_state_master';
$route['api/state/fetch/(:num)'] = 'Api_controller/gems_fetch_state_master/$1';
$route['api/state/edit/(:num)'] = 'Api_controller/gems_edit_state_master/$1';
$route['api/state/delete/(:num)'] = 'Api_controller/gems_delete_state_master/$1';
$route['api/state'] = 'Api_controller/get_state_master_list';
$route['api/statelist'] = 'Api_controller/get_updated_state_master_list';
$route['api/citylist'] = 'Api_controller/get_updated_city_master_list';
$route['api/blocklist'] = 'Api_controller/get_updated_block_master_list';






// Designation Master
$route['api/designation/create'] = 'Api_controller/gems_create_designation_master';
$route['api/designation/edit'] = 'Api_controller/gems_edit_designation_master';
$route['api/designation/fetch/(:num)'] = 'Api_controller/gems_fetch_designation_master/$1';
$route['api/designation/delete/(:num)'] = 'Api_controller/gems_delete_designation_master/$1';
$route['api/designation'] = 'Api_controller/get_designation_master_list';

//Department Master

$route['api/department/create'] = 'Api_controller/gems_create_department_master';
$route['api/department/edit'] = 'Api_controller/gems_edit_department_master';
$route['api/department/fetch/(:num)'] = 'Api_controller/gems_fetch_department_master/$1';
$route['api/department/delete/(:num)'] = 'Api_controller/gems_delete_department_master/$1';
$route['api/department'] = 'Api_controller/get_department_master_list';

//Category Master


$route['api/category/create'] = 'Api_controller/gems_create_category_master';
$route['api/category/fetch/(:num)'] = 'Api_controller/gems_fetch_category_master/$1';
$route['api/category/edit'] = 'Api_controller/gems_edit_category_master';
$route['api/category/delete/(:num)'] = 'Api_controller/gems_delete_category_master/$1';
$route['api/category'] = 'Api_controller/get_category_master_list';



// Promotional office Master

$route['api/promotional_office/create'] = 'Api_controller/gems_create_promotional_office_master';
$route['api/promotional_office/edit'] = 'Api_controller/gems_edit_promotional_office_master';
$route['api/promotional_office/fetch/(:num)'] = 'Api_controller/gems_fetch_promotional_office/$1';

$route['api/promotional_office/delete/(:num)'] = 'Api_controller/gems_delete_promotional_office_master/$1';
$route['api/promotional_office'] = 'Api_controller/get_promotional_office_master_list';


// Sponsor Master
$route['api/managesponsor'] = 'Api_controller/get_sponsor_master_list';
$route['api/managemkdsponsor'] = 'Api_controller/get_mkd_sponsor_master_list';

$route['api/createsponsor'] = 'Api_controller/gems_create_sponsor_master';
$route['api/editsponsor/(:num)'] = 'Api_controller/gems_fetch_sponsor_master/$1';
$route['api/updatesponsor'] = 'Api_controller/gems_edit_sponsor_master';
$route['api/deletesponsor/(:num)'] = 'Api_controller/gems_delete_sponsor_master/$1';

// HR -  STAFF MANAGEMENT

$route['api/staff/cr_staff_list'] = 'Api_controller/get_cr_staff_master_list';
$route['api/staff/create'] = 'Api_controller/gems_create_staff_master';
$route['api/staff/fetch/(:num)'] = 'Api_controller/gems_fetch_staff_master/$1';
$route['api/staff/fetchvscategory/(:num)'] = 'Api_controller/gems_fetch_staff_vs_category/$1';
$route['api/staff/edit/(:num)'] = 'Api_controller/gems_edit_staff_master/$1';
$route['api/staff/delete/(:num)'] = 'Api_controller/gems_delete_staff_master/$1';
$route['api/staff'] = 'Api_controller/get_staff_master_list';
$route['api/staff/emp_id'] = 'Child_controller/gems_check_emp_id';

$route['api/allotsortstaff'] = 'Api_controller/get_staff_allot_selection_list';


$route['api/staff/fetchvsbreakingperiod/(:num)'] = 'Api_controller/gems_fetch_staff_vs_breaking_period/$1';
$route['api/staff/fetchvsexperience/(:num)'] = 'Api_controller/gems_fetch_staff_vs_experience/$1';
$route['api/staff/view/(:num)'] = 'Api_controller/gems_fetch_staff_master_view/$1';


 
// Image Upload

$route['api/Singleupload/imageupload'] = 'Upload_controller/single_upload';

$route['api/Multipleupload/imageupload'] = 'Upload_controller/multiple_upload';


// Children master routes
$route['api/children'] = 'Child_controller/get_child_master_list';
$route['api/children/create'] = 'Child_controller/gems_create_child_master';
$route['api/children/check_mksno'] = 'Child_controller/gems_check_mks_no';
$route['api/children/fetch/(:num)'] = 'Child_controller/gems_fetch_child_master/$1';
$route['api/children/edit'] = 'Child_controller/gems_edit_child_master';
$route['api/children/delete/(:num)'] = 'Child_controller/gems_delete_child_master/$1';
$route['api/children/staffchild/(:num)'] = 'Child_controller/gems_fetch_staffchild_master/$1';
$route['api/children/getspousedetail'] = 'Child_controller/gems_get_spouse';
$route['api/children/getcadetail'] = 'Child_controller/gems_get_CA';
$route['api/children/addparentdetail'] = 'Child_controller/gems_add_parent_data'; 	
$route['api/children/getparentdetail'] = 'Child_controller/get_parent_master_list';
$route['api/children/updateparent'] = 'Child_controller/update_parent_master_list';
$route['api/children/delete_parentdata/(:num)'] = 'Child_controller/gems_delete_parent_data_master/$1';
$route['api/children/parentdataview/(:num)'] = 'Child_controller/get_parentdata_master_list_view/$1';

//Child Data
$route['api/children/childcreate'] = 'Child_controller/gems_create_childdata_master';
$route['api/childdata'] = 'Child_controller/get_childdata_master_list';
$route['api/children/parentdata/(:num)'] = 'Child_controller/get_parentdata_master_list/$1';

$route['api/delete_childdata/(:num)'] = 'Child_controller/gems_delete_child_data_master/$1';
$route['api/fetch_childdata/(:num)'] = 'Child_controller/gems_fetch_childdata_master/$1';
$route['api/childdata/edit'] = 'Child_controller/gems_edit_childdata_master';


// Region master routes
$route['api/region/create'] = 'Api_controller/gems_create_region_master';
$route['api/region/fetch/(:num)'] = 'Api_controller/gems_fetch_region_master/$1';
$route['api/region/edit'] = 'Api_controller/gems_edit_region_master';
$route['api/region/delete/(:num)'] = 'Api_controller/gems_delete_region_master/$1';
$route['api/region'] = 'Api_controller/get_region_master_list';


$route['api/identity'] = 'Api_controller/get_identity_master_list';
$route['api/identity/create'] = 'Api_controller/gems_create_identity_master';
$route['api/identity/fetch/(:num)'] = 'Api_controller/gems_fetch_identity_master/$1';
$route['api/identity/edit'] = 'Api_controller/gems_update_identity_master';
$route['api/identity/delete/(:num)'] = 'Api_controller/gems_delete_identity_master/$1';
//createidentity

// Staff relieve routes
$route['api/relievestaffs'] = 'Api_controller/gems_relieve_staffs';
$route['api/relievedstaff'] = 'Api_controller/get_relieved_staff_list';

// Staff approve
$route['api/approvestaffs'] = 'Api_controller/gems_approve_staffs';


// Revoke staff
$route['api/revokestaffs'] = 'Api_controller/gems_revoke_staffs';

// Master data routes
$route['api/masterdata/fetch'] = 'Api_controller/gems_fetch_master_data';

// Disciplinary action routes
$route['api/discipline/create'] = 'Api_controller/gems_create_discipline_master';
$route['api/discipline/fetch/(:num)'] = 'Api_controller/gems_fetch_discipline_master/$1';
$route['api/discipline'] = 'Api_controller/gems_discipline_master_list';

// Staff trainee routes
$route['api/staff/training/create'] = 'Api_controller/gems_create_training_master';
$route['api/staff/training/fetch/(:num)'] = 'Api_controller/gems_fetch_training_master/$1';
$route['api/staff/training'] = 'Api_controller/gems_training_master_list';

// Staff transfer routes
$route['api/staff/transfer/create'] = 'Api_controller/gems_create_transfer_master';
$route['api/staff/transfer/fetch/(:num)'] = 'Api_controller/gems_fetch_staff_transfer_master/$1';
$route['api/staff/transfer/history/(:num)'] = 'Api_controller/gems_staff_transfer_history/$1';
$route['api/staff/approve/transfer/(:num)'] = 'Api_controller/gems_approve_staff_transfer/$1';

$route['api/staff/transfer/approveexp'] = 'Api_controller/gems_approve_staff_transfer_vs_experience';

$route['api/sponsorship/create'] = 'Api_controller/gems_create_sponsorship_master';

$route['api/mkdsponsorship/create'] = 'Api_controller/gems_create_mkd_sponsorship_master';

$route['api/getsponsorship'] = 'Api_controller/get_sponsorship_master_list';

$route['api/getmkdsponsorship'] = 'Api_controller/get_mkd_sponsorship_master_list';

$route['api/editsponsorship'] = 'Api_controller/gems_edit_sponsorship_master';

$route['api/editmkdsponsorship'] = 'Api_controller/gems_edit_mkd_sponsorship_master';


$route['api/allotmissionsponsor'] = 'Api_controller/gems_allot_mission_sponsorship';

$route['api/allotchildsponsor'] = 'Api_controller/gems_allot_child_sponsorship';


$route['api/approvemissionsponsor'] = 'Api_controller/gems_approve_mission_sponsorship';

$route['api/approvechildsponsor'] = 'Api_controller/gems_approve_child_sponsorship';


$route['api/fetchsponsorship/(:num)'] = 'Api_controller/gems_fetch_sponsorship_master/$1';
$route['api/viewsponsorship/(:num)'] = 'Api_controller/gems_fetch_sponsorship_master_view/$1';
$route['api/viewsponsor/(:num)'] = 'Api_controller/gems_fetch_sponsor_master_view/$1';
$route['api/sponsorshipdelete/(:num)'] = 'Api_controller/gems_delete_sponsorship_master/$1';

//Approve Sponsorship
$route['api/approvesponsorship'] = 'Api_controller/gems_approve_sponsorship';
$route['api/approvesponsor'] = 'Api_controller/gems_approve_sponsor';



$route['api/getallotmissionary'] = 'Api_controller/get_allot_missionary_master_list';

$route['api/getallotchildlist'] = 'Api_controller/get_allotchild_master_list';


$route['api/getallotchild'] = 'Api_controller/get_mkd_allot_child_master_list';

$route['api/getallotmissionaryapprove'] = 'Api_controller/get_allot_missionary_approve_list';


$route['api/getallotchildapprove'] = 'Api_controller/get_allot_child_approve_list';



$route['api/getallotmissionaryapproved'] = 'Api_controller/get_allot_missionary_approved_list';

$route['api/getallotchildapproved'] = 'Api_controller/get_allot_child_approved_list';


$route['api/getwithdrawllist'] = 'Api_controller/get_withdrawl_list';

$route['api/getwithdrawlchildlist'] = 'Api_controller/get_withdrawl_child_list';

$route['api/insertwithdrawl'] = 'Api_controller/gems_insert_withdrawl_missionary';

$route['api/insertwithdrawlchild'] = 'Api_controller/gems_insert_withdrawl_child';



$route['api/approvewithdrawl'] = 'Api_controller/get_approve_withdrawl_list';

$route['api/approvewithdrawlchild'] = 'Api_controller/get_approve_withdrawl_child_list';


$route['api/updateapprovewithdrawl'] = 'Api_controller/gems_approve_withdrawl_sponsorship';

$route['api/updateapprovewithdrawlchild'] = 'Api_controller/gems_approve_withdrawl_child_sponsorship';


$route['api/getapprovedwithdrawl'] = 'Api_controller/get_approved_withdrawl_list';

$route['api/getapprovedwithdrawlchild'] = 'Api_controller/get_approved_withdrawl_child_list';


//revert sponsorship

$route['api/getrevertsponsorship'] = 'Api_controller/get_revert_sponsorship_list';
$route['api/insertrevertsponsor'] = 'Api_controller/gems_insert_revert_sponsorship';
$route['api/getapproverevertsponsor'] = 'Api_controller/get_approve_revert_sponsorship_list';
$route['api/updateapproverevertsponsor'] = 'Api_controller/gems_approve_revert_sponsorship';
$route['api/getapprovedrevertsponsor'] = 'Api_controller/get_approved_revert_sponsorship_list';

//revert child sponsor
$route['api/getrevertchildsponsorship'] = 'Api_controller/get_revert_child_sponsorship_list';
$route['api/insertrevertchild'] = 'Api_controller/gems_insert_revert_child_sponsorship';
$route['api/approverevertchild'] = 'Api_controller/get_approve_revert_child_list';
$route['api/updaterevertchild'] = 'Api_controller/gems_approve_revert_child_sponsorship';
$route['api/revokerevertchild'] = 'Api_controller/gems_revoke_revert_child_sponsorship';
$route['api/approvedevertchild'] = 'Api_controller/get_approved_revert_child_sponsorship_list';

//Reallot Child
$route['api/reallotchild'] = 'Api_controller/get_reallot_child_master_list';
$route['api/insertreallotchild'] = 'Api_controller/gems_reallot_child_sponsorship';
$route['api/approvereallotchild'] = 'Api_controller/get_reallot_child_approve_list';
$route['api/updateapprovereallotchild'] = 'Api_controller/gems_approve_reallot_child_sponsorship';
$route['api/revokereallotchild'] = 'Api_controller/gems_revoke_reallot_child_sponsorship';
$route['api/approvedreallotchild'] = 'Api_controller/get_reallot_child_approved_list';

//Reallot Missionary
$route['api/reallotmissionary'] = 'Api_controller/get_reallot_missionary_master_list';

$route['api/staffreallotfetch'] = 'Api_controller/get_staff_reallot_selection_list';
$route['api/insertreallotmission'] = 'Api_controller/gems_reallot_mission_sponsorship';
$route['api/reallotapprovelist'] = 'Api_controller/get_reallot_missionary_approve_list';
$route['api/reallotapprovedlist'] = 'Api_controller/get_reallot_missionary_approved_list';

$route['api/revokeallotmissionary'] = 'Api_controller/gems_revoke_mission_sponsorship';

$route['api/revokeallotchild'] = 'Api_controller/gems_revoke_child_sponsorship';

$route['api/revokewithdrawlmissionary'] = 'Api_controller/gems_revoke_withdrawl_sponsorship';

$route['api/revokewithdrawlchild'] = 'Api_controller/gems_revoke_withdrawl_child_sponsorship';

$route['api/revokerevertsponsorship'] = 'Api_controller/gems_revoke_revert_sponsorship';

//Home Projects Master
$route['api/addhomeprojects'] = 'Api_controller/gems_create_home_project_master';
$route['api/gethomeprojects'] = 'Api_controller/get_home_projects_master_list';
$route['api/fetchhomeprojects/(:num)'] = 'Api_controller/gems_fetch_home_project_master/$1';
$route['api/updatehomeproject'] = 'Api_controller/gems_edit_home_project_master';
$route['api/staffZone'] = 'Api_controller/gems_staff_zone_home_project_master';
$route['api/churchZone'] = 'Api_controller/gems_church_zone_home_project_master';


$route['api/delete_homeproject/(:num)'] = 'Api_controller/gems_delete_home_project_master/$1';

//Child Home Project
$route['api/getchildhomeproject'] = 'Api_controller/get_homeproject_child_master_list';
$route['api/createchildhomeproject'] = 'Api_controller/gems_create_home_project_child_master';
$route['api/fetchchildhomeprojects/(:num)'] = 'Api_controller/gems_fetch_child_home_project_master/$1';
$route['api/updatehomeprojectchild'] = 'Api_controller/gems_edit_child_home_project_master';
$route['api/deletechildhomeprojects/(:num)'] = 'Api_controller/gems_delete_child_home_project_master/$1';

//Child Home Project Sponsorship
$route['api/createhomesponsorship'] = 'Api_controller/gems_create_homeproject_sponsorship_master';
$route['api/gethomesponsorship'] = 'Api_controller/get_homeproject_sponsorship_master_list';
$route['api/gethomesponsorshiplist'] = 'Api_controller/get_homeproject_sponsorship_overall_list';

$route['api/updatehomesponsorship'] = 'Api_controller/gems_edit_homeproject_sponsorship_master';

//Home Allot child
$route['api/gethomeallotchild'] = 'Api_controller/get_home_allotchild_master_list';
$route['api/homeprojectallotchild'] = 'Api_controller/gems_homeproject_allot_child_sponsorship';
$route['api/homeallotchildapprove'] = 'Api_controller/get_homeproject_allot_child_approve_list';
$route['api/updatehomeallotchildapprove'] = 'Api_controller/gems_approve_homeproject_child_sponsorship';
$route['api/revokehomeallotchild'] = 'Api_controller/gems_revoke_homeproject_child_sponsorship';
$route['api/homeallotchildapprovedlist'] = 'Api_controller/get_homeproject_allot_child_approved_list';

//Manage Withdrawal home Child
$route['api/withdrawalhomechild'] = 'Api_controller/get_withdrawl_home_child_list';
$route['api/insertwithdrawalhomechild'] = 'Api_controller/gems_insert_withdrawl_home_child';
$route['api/approvewithdrawalhomechild'] = 'Api_controller/get_approve_withdrawl_home_child_list';
$route['api/updatewithdrawalhomechild'] = 'Api_controller/gems_approve_withdrawl_home_child_sponsorship';
$route['api/revokewithdrawalhomechild'] = 'Api_controller/gems_revoke_withdrawl_home_child_sponsorship';
$route['api/approvedwithdrawalhomechild'] = 'Api_controller/get_approved_withdrawl_home_child_list';


//Revert Home Child
$route['api/getreverthomechild'] = 'Api_controller/get_revert_home_child_list';
$route['api/insertreverthomechild'] = 'Api_controller/gems_insert_revert_home_child_sponsorship';
$route['api/approvereverthomechild'] = 'Api_controller/get_approve_revert_home_child_list';
$route['api/updatereverthomechild'] = 'Api_controller/gems_approve_revert_home_child_sponsorship';
$route['api/revokereverthomechild'] = 'Api_controller/gems_revoke_revert_home_child_sponsorship';
$route['api/approvedreverthomechild'] = 'Api_controller/get_approved_revert_home_child_list';

//Reallot CHild Home
$route['api/reallotchildhome'] = 'Api_controller/get_home_reallotchild_master_list';
$route['api/homeprojectreallotchild'] = 'Api_controller/gems_homeproject_reallot_child_sponsorship';
$route['api/updatereallotchild'] = 'Api_controller/gems_approve_homeproject_reallot_child_sponsorship';
$route['api/getreallotchild'] = 'Api_controller/get_homeproject_reallot_child_approve_list';
$route['api/revokereallothomechild'] = 'Api_controller/gems_revoke_homeproject_reallot_child_sponsorship';
$route['api/approvedreallotchildhome'] = 'Api_controller/get_homeproject_reallot_child_approved_list';

//Reports
$route['api/staffreportfilter'] = 'Api_controller/gems_get_staff_report_master';
$route['api/sponsorreportfilter'] = 'Api_controller/gems_get_sponsor_report_master';
$route['api/childreportfilter'] = 'Api_controller/gems_get_child_report_master';


$route['api/insertchurch'] = 'Api_controller/gems_insert_church_master';
$route['api/getchurchlist'] = 'Api_controller/gems_get_church_master';
$route['api/fetchchurch/(:num)'] = 'Api_controller/gems_fetch_church_master/$1';
$route['api/updatechurch'] = 'Api_controller/gems_update_church_master';
$route['api/deletechurch/(:num)'] = 'Api_controller/gems_delete_church_master/$1';
$route['api/viewchurch/(:num)'] = 'Api_controller/gems_fetch_church_master_view/$1';
$route['api/uploadlanddocs'] = 'Api_controller/gems_add_church_land_docs';

//Six Month Report
$route['api/insertsixmonthreport'] = 'Api_controller/gems_insert_six_month_report_master';
$route['api/getsixmonthreport'] = 'Api_controller/gems_get_church_six_month_report_master';
$route['api/fetchsixmonth/(:num)'] = 'Api_controller/gems_fetch_six_month_report_master/$1';
$route['api/updatesixmonth'] = 'Api_controller/gems_update_six_month_report_master';
$route['api/deletesixmonth/(:num)'] = 'Api_controller/gems_delete_church_six_month_master/$1';

//Staff Monthly Report
$route['api/insertstaffmonthreport'] = 'Api_controller/gems_insert_staff_monthly_report_master';
$route['api/getstaffmonthreport'] = 'Api_controller/gems_get_staff_month_report_master';
$route['api/fetchstaffmonth/(:num)'] = 'Api_controller/gems_fetch_staff_month_report_master/$1';
$route['api/updatestaffmonthreport'] = 'Api_controller/gems_update_staff_month_report_master';
$route['api/deletestaffmonth/(:num)'] = 'Api_controller/gems_delete_staff_month_master/$1';
$route['api/viewstaffmonthreport/(:num)'] = 'Api_controller/gems_fetch_staff_month_report_view/$1';
$route['api/findlanguagedatemonthreport'] = 'Api_controller/gems_find_month_date_language_duplicate';



//Flat Report
$route['api/getflatreport'] = 'Api_controller/gems_get_flat_report_master';


//Sponsor Dedication Report
$route['api/getdedicationreport'] = 'Api_controller/gems_get_sponsor_dedication_report_master';

//Pdf Generater
$route['api/pdfreportflatmaster'] = 'Api_controller/gems_get_flat_report_master_pdf';
$route['api/pdfreportstaffmaster'] = 'Api_controller/gems_get_staff_report_master_pdf';


//Growth Chart Report chart master
$route['api/growthchartreport'] = 'Api_controller/gems_get_growth_chart_master';

//Training Growth Chart
$route['api/traininggrowthchart'] = 'Api_controller/gems_get_growth_chart_training_master';

//Program Growth Chart
$route['api/programgrowthchart'] = 'Api_controller/gems_get_growth_chart_program_master';

//Personnel Chart
$route['api/personnelgrowthchart'] = 'Api_controller/gems_get_growth_chart_personnel_master';

//Finance Chart
$route['api/financegrowthchart'] = 'Api_controller/gems_get_growth_chart_finance_master';


//View Staff alloted list
$route['api/fetchallotedlist/(:num)'] = 'Api_controller/gems_fetch_staff_alloted_list/$1';


$route['api/resendwithdrawal'] = 'Api_controller/gems_approve_resent_withdrawl_sponsorship';


$route['api/approvechurch'] = 'Api_controller/gems_approve_church';
$route['api/sixmonthreportapprove'] = 'Api_controller/gems_approve_six_month_report';
$route['api/previewmailallotapprove'] = 'Api_controller/gems_preview_mail_mission_sponsorship';
$route['api/resendmailallotmission'] = 'Api_controller/gems_resend_mail_mission_sponsorship';

//Preview mail Withdrawal
$route['api/previewmailwithdrawal'] = 'Api_controller/gems_preview_mail_approve_withdrawl_sponsorship';

//Preview mail Reallot mission
$route['api/previewmailreallot'] = 'Api_controller/gems_previewmail_approve_mission_sponsorship';
$route['api/resendreallotmission'] = 'Api_controller/gems_resend_reallot_mission_sponsorship';


