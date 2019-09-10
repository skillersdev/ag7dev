export class AppSettings{

	
	
	 public static API_BASE = "http://localhost/ag7dev/trunk/api";	
  	 public static USER_TEMPLATE= "http://localhost/ag7dev/trunk/website";
	 public static IMAGE_BASE = "http://localhost/ag7dev/trunk/api/";
	 public static IMAGE_BASE_CHAT = "http://localhost/ag7dev/trunk/assets/chat/";
	 public static PACKAGE_ACTIVATE = "http://localhost/ag7dev/trunk/api/database/checkbalance.php";
	 public static WEBSITE_URL="http://localhost/ag7dev/trunk/website/";
	 public static package_renew= "http://localhost/ag7dev/trunk/api/database/checkbalance1.php";

	 public static share_link= "http://localhost:4200/chat/join/";
	 public static chatshare= "http://localhost:4200/chat/public/";

	//public static share_link= "https://roodabatoz.com/chat/join/";

 //	public static API_BASE = "https://roodabatoz.com/api";
//	public static USER_TEMPLATE= "https://roodabatoz.com/website";
//	public static IMAGE_BASE = "https://roodabatoz.com/api/";
//	public static IMAGE_BASE_CHAT = "https://roodabatoz.com/assets/chat/";
//	public static PACKAGE_ACTIVATE = "https://roodabatoz.com/api/database/checkbalance.php";
//	public static WEBSITE_URL="https://roodabatoz.com/website/";
//	public static package_renew= "https://roodabatoz.com/api/database/checkbalance1.php";

	
	//public static testinfo = AppSettings.LOCAL_API_BASE; //dashboard api
	public static getDashboardinfo = AppSettings.API_BASE + "/dashboard/dashboardinfo"; //dashboard api

	/*Category add*/
	public static Addcategory = AppSettings.API_BASE + "/addcategory";
	public static getcategoryDetail = AppSettings.API_BASE + "/getcategory"; //common api
	public static categorybyid=AppSettings.API_BASE+"/fetchcategorybyid/";
	

	public static editcategory= AppSettings.API_BASE+"/editcategory/";
	public static updatecategory= AppSettings.API_BASE+"/updatecategory";
	public static deletecategory= AppSettings.API_BASE+"/deletecategory/";
	
	/**/ 

	/*Subcategory*/
	public static Addsubcategory = AppSettings.API_BASE + "/addsubcategory";
	public static getsubcategoryDetail = AppSettings.API_BASE + "/getsubcategory/"; //common api
	public static editsubcategory= AppSettings.API_BASE+"/editsubcategory/";
	public static updatesubcategory= AppSettings.API_BASE+"/updatesubcategory";
	public static deletesubcategory= AppSettings.API_BASE+"/deletesubcategory/";
	public static getsubcategorybyid=AppSettings.API_BASE+"/fetchsubcategory/";
	public static getsubcatlist =AppSettings.API_BASE+"/getsubcatlist/";
	
	/**/
	/*Contacts li*/
	public static Addcontacts = AppSettings.API_BASE + "/addcontacts";
	public static getcontactDetail = AppSettings.API_BASE + "/getcontact"; //common 
	public static getcontactlistbyid= AppSettings.API_BASE+"/editcontactbyid/";
	public static getcontactbyid= AppSettings.API_BASE+"/getcontactbyid/";
	public static updatecontact= AppSettings.API_BASE+"/updatecontact";
	//public static deletesubcategory= AppSettings.API_BASE+"/deletesubcategory/";
	public static deletecontact= AppSettings.API_BASE+"/deletecontact/";
	public static DeletelogimagesRestApiUrl= AppSettings.API_BASE+"/deletecontactlogimages/"; 
	
	
	/**Package APi list**/
	public static Addpackage = AppSettings.API_BASE + "/addpackage"; //common api
	public static getPackageDetail = AppSettings.API_BASE + "/getpackage"; //common api
	public static Editpackage = AppSettings.API_BASE+"/editpackage/";
	public static Updatepackage= AppSettings.API_BASE+"/updatepackage";
	public static deletepackage=AppSettings.API_BASE+"/deletepackage/";
	/*End */

	/*User Api list*/
	public static Adduser=AppSettings.API_BASE+"/adduser";
	public static Addtemplate=AppSettings.API_BASE+"/addtemplate";	
	public static gettemplatelistbyuser=AppSettings.API_BASE+"/gettemplatelistbyuser";	
	public static getuserslist= AppSettings.API_BASE + "/getuserslist";	
	public static getchatuserslist= AppSettings.API_BASE + "/getchatuserslist";	
	public static gettemplatelist =	AppSettings.API_BASE + "/gettemplatelist";	
	public static Edituser = AppSettings.API_BASE+"/edituser/";
	public static Edittemplate = AppSettings.API_BASE+"/edittemplate/";
	public static Updateuser= AppSettings.API_BASE+"/updateuser";
	public static Updatetemp= AppSettings.API_BASE+"/updatetemp";
	public static Updateuserprofile= AppSettings.API_BASE+"/updateuserprofile";	
	public static deleteuser=AppSettings.API_BASE+"/deleteuser/";
	public static checkuserdetail=AppSettings.API_BASE+"/checkuserexist";
	public static checkusercredit=AppSettings.API_BASE+"/checkusercredit";
	public static packageisactivated=AppSettings.API_BASE+"/checkpackage/";
	public static Updatepassword= AppSettings.API_BASE+"/updatepassword";
	public static uploadprofileimage=AppSettings.API_BASE+"/uploadimage";
	public static uploadvideo = AppSettings.API_BASE+"/uploadVideoswebsite";
	public static Deletevideosection=AppSettings.API_BASE+"/deletevideosection/";
	public static uploadAdvfile=AppSettings.API_BASE+"/uploadAdvfile";
	public static uploadTempfile=AppSettings.API_BASE+"/uploadtempfile";
	public static Adduseradvertisement=AppSettings.API_BASE+"/addadvertisment";
	public static getadDetail=AppSettings.API_BASE+"/getadvertisment";
	public static getadDetailbyUser=AppSettings.API_BASE+"/getadvertismentbyuser/";
	public static editad= AppSettings.API_BASE+"/editad/";
	public static updatead= AppSettings.API_BASE+"/updatead";
	public static deletead=AppSettings.API_BASE+"/deletead/";
	public static updateibadetails=AppSettings.API_BASE+"/updateibadetails";
	public static getcategorybywebsite=AppSettings.API_BASE+"/checkcategorybyweb";
	public static getMarketerslistDetail = 	AppSettings.API_BASE+"/getMarketerslist";
	public static reactivatepackagevsuser= 	AppSettings.API_BASE+"/reactivatepackage";

	/**Earnings*/
	public static getearningslist=AppSettings.API_BASE+"/earningslist";
	public static Editearnings = AppSettings.API_BASE+"/editearnings/";
	public static Updateearnings= AppSettings.API_BASE+"/updateearnings/";
	public static Addearnings= AppSettings.API_BASE+"/addearnings";
	public static deleteearnings = AppSettings.API_BASE+"/deleteearnings/";
	/*trasnfer history*/
	public static inserttransferprocess=AppSettings.API_BASE+"/addtransferdetails";
	public static gettransferlistDetail = 	AppSettings.API_BASE+"/gettransferlist";
	
	/**/

    /*Package vs User*/
    public static getPackageInfo= AppSettings.API_BASE+"/getpackagelist/";	
    public static getallPackageInfo	= AppSettings.API_BASE+"/getpackagealllist/";	
    public static checkwebsitedetail= AppSettings.API_BASE+"/checkwebsiteexists";
    public static getwebsitelist = AppSettings.API_BASE+"/getwebsitelist";		
    public static getPackageNotbuy= AppSettings.API_BASE+"/getpackagenotbuy/";
	public static insertpackagevsuser= AppSettings.API_BASE+"/addpackagevsuser";
	public static updatetemplatepackagevsuser= AppSettings.API_BASE+"/updatetemplatepackagevsuser";

    /**/

	//User Login Api Starts here
	public static Userlogin=AppSettings.API_BASE + "/checkuser"; //common api
	public static passwordreset=AppSettings.API_BASE + "/resetpassword"; //common api 
	//User Login Api Ends here


	//paypalpayments/
	public static getpaymentdet= AppSettings.API_BASE+"/getpaymentdetails/";
	public static getallpaymentdet= AppSettings.API_BASE+"/getallpaymentdetails";

	//Product rest api
	public static addproduct= AppSettings.API_BASE+"/addproduct";
	public static productlist= AppSettings.API_BASE+"/productlist";
	public static productlistbyweb= AppSettings.API_BASE+"/productlistbyweb";
	public static editproduct= AppSettings.API_BASE+"/editproduct/";
	public static updateproduct= AppSettings.API_BASE+"/updateproduct";
	public static deleteproduct= AppSettings.API_BASE+"/deleteproduct/"; 
	public static uploadproductimage=AppSettings.API_BASE+"/uploadproductimage";


	public static insertservice= AppSettings.API_BASE+"/addservice"; 
	public static getservicelist= AppSettings.API_BASE+"/getservice"; 
	public static getservicebyid= AppSettings.API_BASE+"/editservice/";


	public static updateservice= AppSettings.API_BASE+"/updateservice";
	public static deleteservicedata= AppSettings.API_BASE+"/deleteservice/";
	public static uploadserviceimage=AppSettings.API_BASE+"/uploadserviceimage";
	public static getservicebyuser=AppSettings.API_BASE+"/getservicebyuser";

	//Group
	public static addgroup=AppSettings.API_BASE+"/addgroup";
	public static getgroups=AppSettings.API_BASE+"/getgroups";
	public static getmygroups=AppSettings.API_BASE+"/getmygroups";
	public static getgroupsdetails=AppSettings.API_BASE+"/getgroupsdetails";
	public static getgroupsdetailspublic=AppSettings.API_BASE+"/getgroupsdetailspublic";
	public static sendmsg=AppSettings.API_BASE+"/sendmsg";
 	public static deletePackageDetails = AppSettings.API_BASE+"/deletepackagedetails"; 
	public static groupimage=AppSettings.API_BASE+"/groupimage";
	public static updategroup=AppSettings.API_BASE+"/updategroup";
	public static deletegroup=AppSettings.API_BASE+"/deletegroup";
	public static exitgroup=AppSettings.API_BASE+"/exitgroup";
	public static msggroupimage=AppSettings.API_BASE+"/msggroupimage";
	public static checkuserIsgroupRestApiUrl=AppSettings.API_BASE+"/checkuserhavinggroup";
	public static addusergroupApiUrl=AppSettings.API_BASE+"/addusertogroup";
    
    public static getchatgroupslist=AppSettings.API_BASE+"/getchatgroupslist";
    public static FetchchatbygroupRestApiUrl=AppSettings.API_BASE+"/getchatsbygrouplist/";
    public static codetogroup=AppSettings.API_BASE+"/getcodetogroup";
    public static getmychatcodetogroup=AppSettings.API_BASE+"/getmychatcodetogroup";    
    public static mychatgroup=AppSettings.API_BASE+"/mychatgroup";

	public static FetchsubscribersbygroupRestApiUrl=AppSettings.API_BASE+"/getsubscribersbygrouplist/"; 
	public static DeletesubscriberRestApiUrl=AppSettings.API_BASE+"/deletesubscriber/"; 
	
	public static userweburl=AppSettings.USER_TEMPLATE+"/";
	public static uploadcropimage= AppSettings.API_BASE+"/uploadcropimage";
	public static insertAlbum = AppSettings.API_BASE+"/insertalbum";
	public static getalbumbyuser= AppSettings.API_BASE+"/getalbumbyuser";
	public static getvideolistbywebsiteApiUrl= AppSettings.API_BASE+"/getvideolistbyid";
	public static Editvideo = AppSettings.API_BASE+"/editvideodata/";
	public static updatevideosectiondata=AppSettings.API_BASE+"/uploadvideodata";
	
	
	public static getalbumlistRestApiUrl= AppSettings.API_BASE+"/getalbumlist";
	public static uploadalbumimage=AppSettings.API_BASE+"/uploadalbumimage";
	public static FetchAlbumbyidRestApiUrl= AppSettings.API_BASE+"/editalbum/";
	public static updatealbumRestApiUrl = AppSettings.API_BASE+"/updatealbum";
	public static DeletealbumRestApiUrl=AppSettings.API_BASE+"/deletealbum/";
	public static uploadalbumphotosApi = AppSettings.API_BASE+"/uploadalbumphotos";
	public static uploadvideoPreviewApi= AppSettings.API_BASE+"/uploadvideopreview";
	public static addvideosectiondata = AppSettings.API_BASE+"/insertvideosectiondata";
	public static DeletegalleryimagesRestApiUrl =AppSettings.API_BASE+"/deletealbumphotos/";
 
	
	/*mall add*/
	public static Addmall = AppSettings.API_BASE + "/addmall";
	public static getmallDetail = AppSettings.API_BASE + "/getmall"; //common api
	public static mallbyid=AppSettings.API_BASE+"/fetchmallbyid/";
	public static editmall= AppSettings.API_BASE+"/editmall/";
	public static updatemall= AppSettings.API_BASE+"/updatemall";
	public static deletemall= AppSettings.API_BASE+"/deletemall/";	
	/**/ 
	/*floor add*/
	public static Addfloor = AppSettings.API_BASE + "/addfloor";
	public static getfloorDetail = AppSettings.API_BASE + "/getfloor"; //common api
	public static floorbyid=AppSettings.API_BASE+"/fetchfloorbyid/";
	public static editfloor= AppSettings.API_BASE+"/editfloor/";
	public static updatefloor= AppSettings.API_BASE+"/updatefloor";
	public static deletefloor= AppSettings.API_BASE+"/deletefloor/";

	/*shop add*/
	public static Addshop = AppSettings.API_BASE + "/addshop";
	public static getshopDetail = AppSettings.API_BASE + "/getshop"; //common api
	public static shopbyid=AppSettings.API_BASE+"/fetchshopbyid/";
	public static editshop= AppSettings.API_BASE+"/editshop/";
	public static updateshop= AppSettings.API_BASE+"/updateshop";
	public static deleteshop= AppSettings.API_BASE+"/deleteshop/";
	public static getfloorbymallid= AppSettings.API_BASE+"/getfloorbymallid";	
	/**/ 

	/*mall product add*/
	public static Addmallproduct = AppSettings.API_BASE + "/addmallproduct";
	public static getmallproductDetail = AppSettings.API_BASE + "/getmallproduct"; //common api
	public static mallproductbyid=AppSettings.API_BASE+"/fetchmallproductbyid/";
	public static editmallproduct= AppSettings.API_BASE+"/editmallproduct/";
	public static updatemallproduct= AppSettings.API_BASE+"/updatemallproduct";
	public static deletemallproduct= AppSettings.API_BASE+"/deletemallproduct/";
	public static getshopbyfloorid= AppSettings.API_BASE+"/getshopbyfloorid";
	public static imageupload= AppSettings.API_BASE+"/imageupload";	

	public static Malllogin = AppSettings.API_BASE + "/malllogin";
}
