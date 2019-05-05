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

$route['common'] = 'Api_controller/index';
$route['checkuser'] = 'Login_controller/checklogin';
$route['resetpassword'] = 'User_controller/resetpassword';

/******Package Module API List*********/
$route['addpackage'] = 'Package_controller/add_package_master';
$route['getpackage'] = 'Package_controller/get_package_list';
$route['editpackage/(:num)'] = 'Package_controller/editpackage/$1';
$route['updatepackage'] = 'Package_controller/updatepackage';
$route['deletepackage/(:num)'] = 'Package_controller/deletepackage/$1';
/*************** */

/***Add catgeory****/
$route['addcategory'] = 'Category_controller/add_category';
$route['getcategory'] = 'Category_controller/get_category_list';
$route['editcategory/(:num)'] = 'Category_controller/editcategory/$1';
$route['updatecategory'] = 'Category_controller/updatecategory';
$route['deletecategory/(:num)']='Category_controller/deletecategory/$1';
$route['checkcategorybyweb']='Category_controller/getcategorybyweb';
/*******/

/***Add subcatgeory****/
$route['addsubcategory'] = 'Category_controller/add_subcategory';
$route['getsubcategory'] = 'Category_controller/get_sub_category_list';
$route['editsubcategory/(:num)'] = 'Category_controller/editsubcategory/$1';
$route['updatesubcategory'] = 'Category_controller/updatesubcategory';
$route['deletesubcategory/(:num)']='Category_controller/deletesubcategory/$1';
$route['fetchsubcategory/(:num)']='Category_controller/getsubcategorybyid/$1';
/*******/


/*User API */
$route['adduser'] = 'User_controller/add_user_master';
$route['getuserslist'] = 'User_controller/get_users_detail';
$route['edituser/(:num)'] = 'User_controller/edituser/$1';
$route['updateuser'] = 'User_controller/updateuser';
$route['updateuserprofile'] = 'User_controller/updateuserprofile';
$route['deleteuser/(:num)'] = 'User_controller/deleteuser/$1';
$route['checkuserexist'] = 'User_controller/check_user_exist';
$route['checkusercredit'] = 'User_controller/check_user_credit';
$route['checkpackage/(:num)'] = 'Login_controller/check_user_package/$1';
$route['updatepassword'] = 'User_controller/updatepassword';
$route['uploadimage'] = 'User_controller/uploadimage';
$route['uploadAdvfile']= 'User_controller/uploadAdvfile';
$route['addadvertisment']= 'User_controller/add_user_ad';
$route['getadvertisment']= 'User_controller/get_user_ad';
$route['editad/(:num)'] = 'User_controller/editad/$1'; 
$route['updatead']= 'User_controller/updatead';
$route['deletead/(:num)'] = 'User_controller/deletead/$1';
$route['updateibadetails'] = 'User_controller/updateibadetails';
$route['getMarketerslist'] = 'User_controller/getmarketerslist';
/*Trasnfer History*/
 $route['addtransferdetails'] = 'Transferhistory_controller/add_transfer_history';
/**/

/*Earnings list*/
$route['earningslist'] = 'Package_controller/getearningslist';
$route['editearnings/(:num)']= 'Package_controller/editearnings/$1';
$route['updateearnings'] = 'Package_controller/updateearnings';
$route['addearnings'] = 'Package_controller/addearnings';
$route['deleteearnings/(:num)'] = 'Package_controller/deleteearnings/$1';


/**/

/*Package vs info API*/
$route['getpackagelist/(:num)'] = 'Package_controller/get_package_info/$1';
$route['getpackagealllist']='Package_controller/get_all_package';
$route['checkwebsiteexists'] = 'Package_controller/check_website_exists';
$route['getwebsitelist']= 'Package_controller/get_website_list';

$route['getpaymentdetails/(:num)'] = 'Paymentinfo_controller/get_payment_details/$1';
$route['getallpaymentdetails'] = 'Paymentinfo_controller/get_all_payment_details'; 
$route['getpackagenotbuy/(:num)'] = 'Package_controller/get_package_not_buy/$1';
$route['addpackagevsuser']= 'Package_controller/addpackagevsuser';
$route['updatetemplatepackagevsuser']= 'Package_controller/updatetemplatepackagevsuser';

/*Product Add*/
$route['addproduct'] = 'Product_controller/addproduct';
$route['productlist']= 'Product_controller/productlist';
$route['editproduct/(:num)']='Product_controller/editproduct/$1';
$route['updateproduct']= 'Product_controller/updateproduct';
$route['deleteproduct/(:num)'] = 'Product_controller/deleteproduct/$1';
$route['uploadproductimage']='Product_controller/uploadproductimage';


/*Contacts master*/
$route['addcontacts'] = 'Contacts_controller/addcontacts';
$route['getcontact']= 'Contacts_controller/get_contact_list';
$route['editcontactbyid/(:num)']='Contacts_controller/editcontact/$1';
$route['updatecontact']= 'Contacts_controller/updatecontact';
$route['addservice'] = 'Service_controller/addservice';
$route['getservice']= 'Service_controller/get_all_service_details';
$route['editservice/(:num)']='Service_controller/editservice/$1';
$route['updateservice'] = 'Service_controller/updateservice';
$route['deleteservice/(:num)'] = 'Service_controller/deleteservice/$1';
$route['deletecontact/(:num)']= 'Contacts_controller/deletecontact/$1';
$route['uploadserviceimage']='Service_controller/uploadserviceimage';
?>


