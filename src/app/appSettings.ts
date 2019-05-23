export class AppSettings{

	
	public static API_BASE = "http://localhost/ag7dev.git/trunk/api";
	public static USER_TEMPLATE= "http://localhost/ag7dev.git/trunk/website";
	public static IMAGE_BASE = "http://localhost/ag7dev.git/trunk/api/";
	public static IMAGE_BASE_CHAT = "http://localhost/ag7dev.git/trunk/src/assets/chat/";
	public static PACKAGE_ACTIVATE = "http://localhost/ag7dev.git/trunk/api/database/checkbalance.php";
	public static WEBSITE_URL="http://localhost/ag7dev.git/trunk/website/";
	public static package_renew= "http://localhost/ag7dev.git/trunk/api/database/checkbalance1.php";


	
	//public static testinfo = AppSettings.LOCAL_API_BASE; //dashboard api
	public static getDashboardinfo = AppSettings.API_BASE + "/dashboard/dashboardinfo"; //dashboard api

	/*Category add*/
	public static Addcategory = AppSettings.API_BASE + "/addcategory";
	public static getcategoryDetail = AppSettings.API_BASE + "/getcategory"; //common api

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
	
	/**/
	/*Contacts li*/
	public static Addcontacts = AppSettings.API_BASE + "/addcontacts";
	public static getcontactDetail = AppSettings.API_BASE + "/getcontact"; //common 
	public static getcontactlistbyid= AppSettings.API_BASE+"/editcontactbyid/";
	public static updatecontact= AppSettings.API_BASE+"/updatecontact";
	//public static deletesubcategory= AppSettings.API_BASE+"/deletesubcategory/";
	public static deletecontact= AppSettings.API_BASE+"/deletecontact/";
	
	
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
	public static getuserslist= AppSettings.API_BASE + "/getuserslist";	
	public static gettemplatelist =	AppSettings.API_BASE + "/gettemplatelist";	
	public static Edituser = AppSettings.API_BASE+"/edituser/";
	public static Updateuser= AppSettings.API_BASE+"/updateuser";
	public static Updateuserprofile= AppSettings.API_BASE+"/updateuserprofile";	
	public static deleteuser=AppSettings.API_BASE+"/deleteuser/";
	public static checkuserdetail=AppSettings.API_BASE+"/checkuserexist";
	public static checkusercredit=AppSettings.API_BASE+"/checkusercredit";
	public static packageisactivated=AppSettings.API_BASE+"/checkpackage/";
	public static Updatepassword= AppSettings.API_BASE+"/updatepassword";
	public static uploadprofileimage=AppSettings.API_BASE+"/uploadimage";
	public static uploadAdvfile=AppSettings.API_BASE+"/uploadAdvfile";
	public static Adduseradvertisement=AppSettings.API_BASE+"/addadvertisment";
	public static getadDetail=AppSettings.API_BASE+"/getadvertisment";
	public static getadDetailbyUser=AppSettings.API_BASE+"/getadvertismentbyuser/";
	public static editad= AppSettings.API_BASE+"/editad/";
	public static updatead= AppSettings.API_BASE+"/updatead";
	public static deletead=AppSettings.API_BASE+"/deletead/";
	public static updateibadetails=AppSettings.API_BASE+"/updateibadetails";
	public static getcategorybywebsite=AppSettings.API_BASE+"/checkcategorybyweb";
	public static getMarketerslistDetail = 	AppSettings.API_BASE+"/getMarketerslist";
	/* */

	/**Earnings*/
	public static getearningslist=AppSettings.API_BASE+"/earningslist";
	public static Editearnings = AppSettings.API_BASE+"/editearnings/";
	public static Updateearnings= AppSettings.API_BASE+"/updateearnings/";
	public static Addearnings= AppSettings.API_BASE+"/addearnings";
	public static deleteearnings = AppSettings.API_BASE+"/deleteearnings/";
	/*trasnfer history*/
	public static inserttransferprocess=AppSettings.API_BASE+"/addtransferdetails";
	
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

	//Group
	public static addgroup=AppSettings.API_BASE+"/addgroup";
	public static getgroups=AppSettings.API_BASE+"/getgroups";


	public static userweburl=AppSettings.USER_TEMPLATE+"/";
}