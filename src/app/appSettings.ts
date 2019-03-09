export class AppSettings{

	//public static API_BASE = "http://php55.development.local/php17052301_sspandian_erp/ver1/api";
	public static API_BASE = "http://localhost/ag7dev.git/trunk/api";
	public static IMAGE_BASE = "http://localhost/ag7dev.git/trunk/api/";

	//public static API_BASE = "http://erp.buyperungayam.com/api";


	//public static testinfo = AppSettings.LOCAL_API_BASE; //dashboard api
	public static getDashboardinfo = AppSettings.API_BASE + "/dashboard/dashboardinfo"; //dashboard api
	
	/**Package APi list**/
	public static Addpackage = AppSettings.API_BASE + "/addpackage"; //common api
	public static getPackageDetail = AppSettings.API_BASE + "/getpackage"; //common api
	public static Editpackage = AppSettings.API_BASE+"/editpackage/";
	public static Updatepackage= AppSettings.API_BASE+"/updatepackage";
	public static deletepackage=AppSettings.API_BASE+"/deletepackage/";
	/*End */

	/*User Api list*/
	public static Adduser=AppSettings.API_BASE+"/adduser";
	public static getuserslist= AppSettings.API_BASE + "/getuserslist";		
	public static Edituser = AppSettings.API_BASE+"/edituser/";
	public static Updateuser= AppSettings.API_BASE+"/updateuser";
	public static Updateuserprofile= AppSettings.API_BASE+"/updateuserprofile";	
	public static deleteuser=AppSettings.API_BASE+"/deleteuser/";
	public static checkuserdetail=AppSettings.API_BASE+"/checkuserexist";
	public static checkusercredit=AppSettings.API_BASE+"/checkusercredit";
	public static packageisactivated=AppSettings.API_BASE+"/checkpackage/";
	public static Updatepassword= AppSettings.API_BASE+"/updatepassword";
	public static uploadprofileimage=AppSettings.API_BASE+"/uploadimage";

	/* */

	/*trasnfer history*/
	public static inserttransferprocess=AppSettings.API_BASE+"/addtransferdetails";
	
	/**/

    /*Package vs User*/
    public static getPackageInfo= AppSettings.API_BASE+"/getpackagelist/";		
    

    /**/

	//User Login Api Starts here
	public static Userlogin=AppSettings.API_BASE + "/checkuser"; //common api
	public static passwordreset=AppSettings.API_BASE + "/resetpassword"; //common api 
	//User Login Api Ends here
}