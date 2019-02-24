export class AppSettings{

	//public static API_BASE = "http://php55.development.local/php17052301_sspandian_erp/ver1/api";
	public static API_BASE = "http://localhost/ag7dev.git/trunk/api";
	//public static API_BASE = "http://preview56.24x7a2z.com/bluberrydemo/api";

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
	//User Login Api Starts here
	public static Userlogin=AppSettings.API_BASE + "/user/login"; //common api
	//User Login Api Ends here
}