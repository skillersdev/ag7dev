<?php
//ini_set('display_errors', 1);
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
$route['updategroupandchatforolduser']= 'User_controller/updategroupandchatforolduser';

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
$route['fetchcategorybyid/(:num)']='Category_controller/fetchcategorybyid/$1';
$route['checkcategorybyweb']='Category_controller/getcategorybyweb';
/*******/
$route['fetchenquirylistbyid/(:num)']='Sectionitem_controller/getenquirylistbyuser/$1';
$route['fetchenquirylist']='Sectionitem_controller/getenquirylist';

$route['fetchenquiryproductlistbyid/(:num)']='Sectionitem_controller/getproductenquirylistbyuser/$1';
$route['fetchenquiryproductlist']='Sectionitem_controller/getproductenquirylist';


/***Add subcatgeory****/
$route['addsubcategory'] = 'Category_controller/add_subcategory';
$route['getsubcategory'] = 'Category_controller/get_sub_category_list';
$route['editsubcategory/(:num)'] = 'Category_controller/editsubcategory/$1';
$route['updatesubcategory'] = 'Category_controller/updatesubcategory';
$route['deletesubcategory/(:num)']='Category_controller/deletesubcategory/$1';
$route['fetchsubcategory/(:num)']='Category_controller/getsubcategorybyid/$1';
$route['getsubcatlist/(:num)']='Category_controller/getsubcategorylistbyuser/$1';
/*******/

/***Manage Section****/
$route['addsection'] = 'Section_controller/addsection';
$route['getsectionlist'] = 'Section_controller/getsectionlist';
$route['getdefaultsectionlist']= 'Section_controller/getdefaultsectionlist';
$route['editsection/(:num)'] = 'Section_controller/editsection/$1';
$route['editsectionitem/(:num)']= 'Sectionitem_controller/editsectionitem/$1';


$route['updatesectiondata'] = 'Section_controller/updatesection';
$route['updatesectionItem']= 'Sectionitem_controller/updatesectionItem';
$route['deletesection/(:num)'] = 'Section_controller/deletesection/$1';
$route['updatesectiontoggle']= 'Section_controller/updatesectionbytoggle';
$route['sectionreordersave']= 'Section_controller/sectionreordersave';
$route['sectionItemreordersave']= 'Sectionitem_controller/sectionreordersave';


$route['getsectionitemlist'] = 'Sectionitem_controller/getsectionitemlist';
$route['getsectionlistbyshow']= 'Section_controller/getsectionlistbyshow';
$route['getalbumlistbyshow']= 'Gallery_controller/getalbumlistbyshow';
$route['getalbumlistbyuser']= 'Gallery_controller/getalbumbyuser';
$route['getsectionItemlistbyshow']= 'Sectionitem_controller/getsectionitemlistbyshow';
$route['uploadcropserviceimage']='Section_controller/uploadcropserviceimage';
$route['uploadMultipleImagesSectionItem']='Section_controller/MultipleUploadsectionItem';
$route['addsectionitem']= 'Sectionitem_controller/addsectionitem';
$route['sectionitemvideoupload']= 'Sectionitem_controller/uploadsectionitemvideo';
$route['deletesectionitem/(:num)']= 'Sectionitem_controller/deletesectionitem/$1';
/*******/


/*User API */
$route['adduser'] = 'User_controller/add_user_master';
$route['addtemplate']= 'User_controller/add_template_master';
$route['gettemplatelistbyuser/(:num)']='User_controller/get_templatelistby_user/$1';
$route['deletetemplateslider/(:num)']='User_controller/deletetemplateslider/$1';
$route['getuserslist'] = 'User_controller/get_users_detail';
$route['getchatuserslist'] = 'User_controller/get_chatusers_detail';
$route['gettemplatelist']= 'User_controller/get_template_list';
$route['edituser/(:num)'] = 'User_controller/edituser/$1';
$route['edittemplate/(:num)']= 'User_controller/edittemplate/$1';
$route['updateuser'] = 'User_controller/updateuser';
$route['updatedefaultsections'] = 'User_controller/updatedefaultsections';

$route['updatetemp']= 'User_controller/updatetemp';
$route['updateuserprofile'] = 'User_controller/updateuserprofile';
$route['reactivatepackage']= 'User_controller/reactivatepackage';
$route['deleteuser/(:num)'] = 'User_controller/deleteuser/$1';
$route['checkuserexist'] = 'User_controller/check_user_exist';
$route['checkusercredit'] = 'User_controller/check_user_credit';
$route['checkusercreditbytype'] = 'User_controller/check_user_credit_by_type';
$route['checkpackage/(:num)'] = 'Login_controller/check_user_package/$1';
$route['updatepassword'] = 'User_controller/updatepassword';
$route['uploadimage'] = 'User_controller/uploadimage';
$route['uploadVideoswebsite'] = "Videosection_controller/uploadvideoswebsite";
$route['uploadvideodata'] = 'Videosection_controller/updatevideodata';
$route['deletevideosection/(:num)'] = 'Videosection_controller/deletevideosection/$1';

$route['uploadlogoimage'] = 'User_controller/uploadlogoimage';
$route['editvideodata/(:num)']= "Videosection_controller/editvideodata/$1";
$route['uploadcropimage']= 'User_controller/uploadcropimage';
$route['uploadAdvfile']= 'User_controller/uploadAdvfile';
$route['uploadtempfile']= 'User_controller/uploadtempfile';
$route['addadvertisment']= 'User_controller/add_user_ad';
$route['getadvertisment']= 'User_controller/get_user_ad';
$route['getadvertismentbyuser/(:num)']= 'User_controller/get_ad_by_user/$1';
$route['editad/(:num)'] = 'User_controller/editad/$1'; 
$route['updatead']= 'User_controller/updatead';
$route['deletead/(:num)'] = 'User_controller/deletead/$1';
$route['updateibadetails'] = 'User_controller/updateibadetails';
$route['getMarketerslist'] = 'User_controller/getmarketerslist';
$route['getAllmarketers']= 'User_controller/getallmarketers';
$route['findmarketers']= 'User_controller/findmarketers';
/*Trasnfer History*/
 $route['addtransferdetails'] = 'Transferhistory_controller/add_transfer_history';
 $route['addtransfervoucher'] = 'Transferhistory_controller/addtransfervoucher';
 $route['transferInstructoramount']= 'Transferhistory_controller/transferinstructoramount';
 $route['gettransferlist'] ='Transferhistory_controller/gettransferlist';
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
$route['getpackagebyadmin'] = 'Package_controller/get_package_list_by_admin';
$route['getpackagealllist']='Package_controller/get_all_package';
$route['checkwebsiteexists'] = 'Package_controller/check_website_exists';
$route['getwebsitelist']= 'Package_controller/get_website_list';

$route['getpaymentdetails/(:num)'] = 'Paymentinfo_controller/get_payment_details/$1';
$route['getallpaymentdetails'] = 'Paymentinfo_controller/get_all_payment_details'; 
$route['getpackagenotbuy/(:num)'] = 'Package_controller/get_package_not_buy/$1';
$route['getpackagebyinstructor']= 'Package_controller/getpackagebyinstructor';
$route['addpackagevsuser']= 'Package_controller/addpackagevsuser';
$route['updatetemplatepackagevsuser']= 'Package_controller/updatetemplatepackagevsuser';
$route['updatelogopackagevsuser']= 'Package_controller/updatelogopackagevsuser';


$route['getPackageType/(:num)'] = 'Package_controller/getPackageType/$1';
$route['getFloorname/(:num)'] = 'Floor_controller/getFloordetails/$1';
$route['getShopcode']= 'Shop_controller/getShopcode';


/*Product Add*/
$route['addproduct'] = 'Product_controller/addproduct';
$route['productlist']= 'Product_controller/productlist';
$route['productlistbyweb']= 'Product_controller/productlistbyweb';
$route['editproduct/(:num)']='Product_controller/editproduct/$1';
$route['updateproduct']= 'Product_controller/updateproduct';
$route['deleteproduct/(:num)'] = 'Product_controller/deleteproduct/$1';
$route['uploadproductimage']='Product_controller/uploadproductimage';


/*Contacts master*/
$route['addcontacts'] = 'Contacts_controller/addcontacts';
$route['getcontact']= 'Contacts_controller/get_contact_list';
$route['editcontactbyid/(:num)']='Contacts_controller/editcontact/$1';
$route['getcontactbyid/(:num)']='Contacts_controller/getcontactbyid/$1';
$route['updatecontact']= 'Contacts_controller/updatecontact';
$route['addservice'] = 'Service_controller/addservice';
$route['getservice']= 'Service_controller/get_all_service_details';
$route['editservice/(:num)']='Service_controller/editservice/$1';
$route['updateservice'] = 'Service_controller/updateservice';
$route['deleteservice/(:num)'] = 'Service_controller/deleteservice/$1';
$route['deletecontact/(:num)']= 'Contacts_controller/deletecontact/$1';
$route['deletecontactlogimages/(:num)']= 'Contacts_controller/deletecontactlogimages/$1';
$route['uploadserviceimage']='Service_controller/uploadserviceimage';
$route['getservicebyuser'] = 'Service_controller/getservicebyuser';

//group
$route['addgroup']= 'Group_controller/addgroup';
$route['getgroups']= 'Group_controller/getgroups';
$route['getmygroups']= 'Group_controller/getmygroups';
$route['getgroupsdetails']= 'Group_controller/getgroupsdetails';
$route['getgroupsdetailspublic']= 'Group_controller/getgroupsdetailspublic';

$route['sendmsg']= 'Group_controller/sendmsg';
$route['deletepackagedetails'] = 'Package_controller/deletepackagedetails';
$route['groupimage']= 'Group_controller/groupimage';
$route['updategroup']= 'Group_controller/updategroup';
$route['deletegroup']= 'Group_controller/deletegroup';
$route['exitgroup']= 'Group_controller/exitgroup';
$route['msggroupimage']= 'Group_controller/msggroupimage'; 
$route['checkuserhavinggroup']= 'Group_controller/checkuserhavinggroup'; 
$route['addusertogroup'] = 'Group_controller/addusertogroup'; 
$route['sendrequestforgroup']= 'Group_controller/sendrequestforgroup'; 
$route['getgrouprequestlist']= 'Group_controller/getgrouprequestlist';
$route['updategrouprequest'] = 'Group_controller/updategrouprequest';
$route['rejectgrouprequest/(:num)']= 'Group_controller/rejectgrouprequest/$1';
$route['getchatgroupslist'] = 'Group_controller/getchatgroupslist';
$route['getchatsbygrouplist/(:num)']= 'Group_controller/getchatslistbygroup/$1';
$route['getsubscribersbygrouplist/(:num)']= 'Group_controller/getsubscribersbygrouplist/$1';
$route['deletesubscriber/(:num)']= 'Group_controller/deletesubscriber/$1';
$route['getcodetogroup'] = 'Group_controller/getcodetogroup';
$route['getmychatcodetogroup'] = 'Group_controller/getmychatcodetogroup';
$route['mychatgroup'] = 'Group_controller/mychatgroup';
$route['chatmsgdelete'] = 'Group_controller/chatmsgdelete';
$route['chatmsgedit'] = 'Group_controller/chatmsgedit';
$route['chatmsgupdate'] = 'Group_controller/chatmsgupdate';
$route['makegroupadmin'] = 'Group_controller/makegroupadmin';
$route['groupuseraddreove'] = 'Group_controller/groupuseraddreove';
$route['chatprofilesave'] = 'Group_controller/chatprofilesave';
$route['chatwebsiteflag'] = 'Group_controller/chatwebsiteflag';
$route['pimage']= 'Group_controller/pimage';


$route['insertalbum'] = 'Gallery_controller/addalbum';
$route['getalbumbyuser']= 'Gallery_controller/getalbumbyuser';
$route['getalbumlist']= 'Gallery_controller/getalbumlist';
$route['uploadalbumimage']= 'Gallery_controller/uploadalbumimage';
$route['editalbum/(:num)']= 'Gallery_controller/editalbum/$1';
$route['updatealbum'] = 'Gallery_controller/updatealbum';
$route['deletealbum/(:num)']= 'Gallery_controller/deletealbum/$1';
$route['uploadalbumphotos'] ='Gallery_controller/addalbumphotos';
$route['uploadvideopreview']='Videosection_controller/addvideopreview';
$route['insertvideosectiondata']='Videosection_controller/addvideosection';
$route['getvideolistbyid']= 'Videosection_controller/getvideolistbyuser';
$route['getvideopagesearchresult']= 'Videosection_controller/searchvideoresult';
$route['getchannelpagesearchresult']= 'Channel_controller/searchchannelresult';
$route['albumItemreordersave']= 'Gallery_controller/albumreordersave';

$route['deletealbumphotos/(:num)']= 'Gallery_controller/deletealbumphotos/$1';

/*** Mall****/
$route['addmall'] = 'Mall_controller/add_mall';
$route['getmall'] = 'Mall_controller/get_mall_list';
$route['editmall/(:num)'] = 'Mall_controller/editmall/$1';
$route['updatemall'] = 'Mall_controller/updatemall';
$route['deletemall/(:num)']='Mall_controller/deletemall/$1';
$route['fetchmallbyid/(:num)']='Mall_controller/fetchmallbyid/$1';
$route['useridbymallid'] = 'Mall_controller/useridbymallid';
$route['getmalllist']='Mall_controller/getmalllist';
$route['getadminmalllist']='Mall_controller/getadminmalllist';
$route['getmallshoplist']='Mall_controller/getmallshoplist';
/*******/

/*** floor****/
$route['addfloor'] = 'Floor_controller/add_floor';
$route['getfloor'] = 'Floor_controller/get_floor_list';
$route['admingetfloor'] = 'Floor_controller/get_admin_floor_list';
$route['editfloor/(:num)'] = 'Floor_controller/editfloor/$1';
$route['updatefloor'] = 'Floor_controller/updatefloor';
$route['deletefloor/(:num)']='Floor_controller/deletefloor/$1';
$route['fetchfloorbyid/(:num)']='Floor_controller/fetchfloorbyid/$1';
$route['getfloorbymallid'] = 'Floor_controller/getfloorbymallid';
/*******/

/*** shop****/
$route['addshop'] = 'Shop_controller/add_shop';
$route['getshop'] = 'Shop_controller/get_shop_list';
$route['editshop/(:num)'] = 'Shop_controller/editshop/$1';
$route['updateshop'] = 'Shop_controller/updateshop';
$route['deleteshop/(:num)']='Shop_controller/deleteshop/$1';
$route['fetchshopbyid/(:num)']='Shop_controller/fetchshopbyid/$1';
$route['getshopbyfloorid'] = 'Shop_controller/getshopbyfloorid';
$route['getshopbymallidfloorid'] = 'Shop_controller/getshopbymallidfloorid';
$route['createorder'] = 'Shop_controller/add_order';
$route['getorders'] = 'Shop_controller/getOrdersbyShopid/$1';

$route['createcategory'] = 'Shop_controller/add_product_category';
$route['getcategory'] = 'Shop_controller/getCategorybyShopid/$1';
$route['deleteshopcategory/(:num)']='Shop_controller/deleteshopcategory/$1';

$route['shopAction'] = 'Shop_controller/shopAction';




/*******/
/*** Product****/
$route['addmallproduct'] = 'Mallproduct_controller/add_mallproduct';
$route['getmallproduct'] = 'Mallproduct_controller/get_mallproduct_list';
$route['editmallproduct/(:num)'] = 'Mallproduct_controller/editmallproduct/$1';
$route['updatemallproduct'] = 'Mallproduct_controller/updatemallproduct';
$route['imageupload'] = 'Mallproduct_controller/imageupload';
$route['deletemallproduct/(:num)']='Mallproduct_controller/deletemallproduct/$1';
$route['fetchmallproductbyid/(:num)']='Mallproduct_controller/fetchmallproductbyid/$1';
$route['getshopmallproduct']='Mallproduct_controller/getshopmallproduct';

// $route['getshopbyfloorid'] = 'Shop_controller/getshopbyfloorid';
/*******/

$route['malllogin'] = 'Malllogin_controller/checklogin';

$route['getrtubevideolist']= 'Home_controller/getrvideolist';
$route['editvideodetail/(:num)']= "Home_controller/editvideodetail/$1";
$route['likevideodetail/(:num)']= "Home_controller/likevideodetail/$1";
$route['getpremiumpackagesettings']= 'Home_controller/getpremiumpackagesettings';
$route['addpremiumpackage']= 'Home_controller/addpremiumpackage';
$route['deletepremiumpackage/(:num)']='Home_controller/deletepremiumpackage/$1';
$route['editpremium/(:num)'] = 'Home_controller/editpremium/$1';
$route['updatepremium']= 'Home_controller/updatepremium';
$route['checkpremiumuserandbalanceexist']= 'Home_controller/checkpremiumuserandbalanceexist';
$route['savepremiumdata']='Home_controller/savepremiumdata';
$route['getpremiumrequestvideos']='Home_controller/getpremiumrequestvideos';
$route['savepremiumrequest']='Home_controller/savepremiumrequest';
$route['getpremiumtransactiondetails']='Home_controller/getpremiumtransactiondetails';

/**Channel creation*/
$route['uploadchannelimage']="Channel_controller/uploadchannelimage";
$route['addchanneldata'] = "Channel_controller/addchanneldata";
$route['getchannellist']= "Channel_controller/getchannellist";
$route['editchannel']= "Channel_controller/editchannel";
$route['updatechanneldata'] = 'Channel_controller/updatechanneldata';
$route['deletechanneldata/(:num)']= 'Channel_controller/deletechanneldata/$1';
$route['checkchannelexist']="Channel_controller/checkchannelexist";
/*****/

/*Common Api  added by mani 02.01.2023*/
$route['getcountrylist']="Common_controller/getCountrylist";
$route['getcurrencylist']="Common_controller/getcurrencylist";

$route['getstatebyCountry/(:num)'] = "Common_controller/getStatelist/$1";
$route['getCitiesbyState/(:num)']= "Common_controller/getCitieslist/$1";
$route['renewPackVoucher']="Common_controller/renewPackVoucher";
/*******/
/**Became Instructor added by sri 02.08.2020**/
$route['activateInstructor']="Instructor_controller/check_user_credit";

$route['updateelearnuserpassword']="Package_controller/updateelearnuserpassword";

$route['sendcontact']= "Common_controller/sendcontactdetails";

?>


