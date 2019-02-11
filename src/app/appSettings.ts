export class AppSettings{

	public static API_BASE = "http://php55.development.local/php17052301_sspandian_erp/ver1/api";
	//public static LOCAL_API_BASE = "http://localhost/ssp_ver1/test/";
	//public static API_BASE = "http://preview56.24x7a2z.com/sspandian/api";

	//public static API_BASE = "http://erp.buyperungayam.com/api";


	//public static testinfo = AppSettings.LOCAL_API_BASE; //dashboard api
	public static getDashboardinfo = AppSettings.API_BASE + "/dashboard/dashboardinfo"; //dashboard api
	
	

	//department   API starts here
	public static getDeptcommon = AppSettings.API_BASE + "/department"; //common api
	public static insertDept = AppSettings.API_BASE + "/department/insert"; //common api
	public static updateDept = AppSettings.API_BASE + "/department/updatedept"; //common api
	
	public static getDept = AppSettings.API_BASE + "/department/getdepartment"; //get list of departments
	public static delDept = AppSettings.API_BASE + "/department/deletedepartment/"; //delete specific departments
	//department  API ends here

	//module list API starts here
	public static getModuleList= AppSettings.API_BASE + "/module"; //Get Module list common api
	public static getModulebypath= AppSettings.API_BASE + "/module/getmodulebypath/"; //Get module List by path
	//module list API ends here

	//User Api starts here
	public static getUsercommon= AppSettings.API_BASE + "/user"; //common api
	public static userimport= AppSettings.API_BASE + "/user/adduser"; //common api	
	public static getUser= AppSettings.API_BASE + "/user/getuser"; //get list of User
	public static delUser= AppSettings.API_BASE + "/user/deleteuser/"; //delete specific User
	public static getUserdept= AppSettings.API_BASE + "/user/getuserdept"; //get list of User Department
	public static updateUser= AppSettings.API_BASE + "/user/update/"; //Update Specific user
	public static getupdateuser= AppSettings.API_BASE + "/user/getupdateuser/"; //Update Specific user
	public static insertuser= AppSettings.API_BASE + "/user/insertuser/"; //common api
	public static checkpassword= AppSettings.API_BASE + "/user/checkpassword/"; //common api
	public static Getuserbyid= AppSettings.API_BASE + "/user/getuserbyid/"; //Getuserbyid api call
	public static Getuserlistbyid= AppSettings.API_BASE + "/user/getuserlistbyid/"; //Getuserbyid api call
	public static Getuserroleid= AppSettings.API_BASE + "/user/getuserbyrole/"; //Getuserbyid api call
	public static Getsalesrep=AppSettings.API_BASE+"/user/getsalesrep";
	public static SalesrepList=AppSettings.API_BASE+"/user/salesreplist";
	public static Getsalesmanagerlist=AppSettings.API_BASE+"/user/salesmanagerlist";
	
	//User Api Ends here

	//Delivery Boy api starts here

	public static Getdeliveryboylistbyid= AppSettings.API_BASE + "/user/getdeliveryboy"; //Getuserbyid api call

	//Delivery Boy api starts here


	//warehousr API starts here
	public static insertWarehouse=AppSettings.API_BASE + "/warehouse"; //common api
	public static delwarehouse=AppSettings.API_BASE + "/warehouse/deletewarehouse/"; //delete specific Warehouse 
	public static checkwarehouse=AppSettings.API_BASE + "/warehouse/checkwarehouse"; //check specific Warehouse 
	public static getWarehouse=AppSettings.API_BASE + "/warehouse/getwarehouse"
	public static updateWarehouse=AppSettings.API_BASE + "/warehouse/update/"; //update api
	//warehouse API ends here

	//Operation Unit Api Starts here
	public static getOperationunitcommon=AppSettings.API_BASE + "/operationunit"; //common api
	//Operation Unit Api Ends here

	public static getScCategorylist=AppSettings.API_BASE + "/expensecategory/getcategory"; //common api

	//User Role Api Starts here
	public static getUserrolecommon=AppSettings.API_BASE + "/userrole"; //common api
	public static adduserrole=AppSettings.API_BASE + "/userrole/adduserrole"; //common api
	public static updateuserrole=AppSettings.API_BASE + "/userrole/updateuserrole"; //common api
	
	
	public static getUserrolelist=AppSettings.API_BASE + "/userrole/getuserrole"; //get user role list api
	public static deleteuserrole=AppSettings.API_BASE + "/userrole/deleteuserrole"; //Delete specific
	//User Role Api Ends here

	//Security manage access api starts here
	public static securityaccesscommon=AppSettings.API_BASE + "/securityaccess"; //Secuirty access api common
	public static insertsecurityapi=AppSettings.API_BASE + "/securityaccess/insertsecurity/"; // Insert Secuirty access
	public static getbyuserroleapi=AppSettings.API_BASE + "/securityaccess/getbyuserrole/"; //
	public static getsecurityaccess=AppSettings.API_BASE + "/securityaccess/getsecurityaccess/"; // Getsecurityaccess
	//Security manage access api ends here

	//User Login Api Starts here
	public static Userlogin=AppSettings.API_BASE + "/user/login"; //common api
	//User Login Api Ends here

	//Manage Product Api Starts here
	public static Productcommon=AppSettings.API_BASE + "/product"; //common api
	public static getProductlist=AppSettings.API_BASE + "/product/getproduct"; //Product list table
	public static AllProductsList=AppSettings.API_BASE + "/product/getproductlist"; //Product list
	public static deleteProduct=AppSettings.API_BASE + "/product/deleteproduct"; //Delete specific Product
	public static updateProduct=AppSettings.API_BASE + "/product/update/"; //Update specific Product
	public static Productopunit=AppSettings.API_BASE + "/product/getopunit/"; //get op_unit for Product
	public static Productcompany=AppSettings.API_BASE + "/product/getcompany/"; //get company for Product
	public static Producteancode=AppSettings.API_BASE + "/product/checkean/"; //check ean for Product
	public static Productunit=AppSettings.API_BASE + "/product/unit/"; //get unit for Product
	public static Productallcompany=AppSettings.API_BASE + "/product/company/"; //get company for Product
	public static ProductFilter=AppSettings.API_BASE + "/product/productfilter"; //get company for Product

	public static getProductlist_pos=AppSettings.API_BASE + "/product/getposproducts"; //Product list
	public static get_POS_Productlist = AppSettings.API_BASE + "/product/posproducts"; //Product list

	public static get_POS_Product_customer = AppSettings.API_BASE + "/product/posproductcustomer"; //Product list
	
	//Manage Product Api Ends here

	//Manage Customer Api Starts here
	public static Customercommon=AppSettings.API_BASE + "/customer"; //common api
	public static getCustomerlist=AppSettings.API_BASE + "/customer/getcustomer"; //Customer list
	public static CustomerDropdownlist = AppSettings.API_BASE + "/customer/customerdropdown"; //Customer list
	public static getCustomerlistselect=AppSettings.API_BASE + "/customer/getcustomerselect"; //Customer list
	public static getCustomerlistselect2=AppSettings.API_BASE + "/customer/getcustomerselect2"; //Select2 Customer list
	public static getCustomerlistpos=AppSettings.API_BASE + "/customer/getcustomerpos"; //Select2 Customer list
	public static Importcustomerlist = AppSettings.API_BASE + "/customer/importcustomer"; //common api
	
	public static Addcustomerpos=AppSettings.API_BASE + "/customer/addcustomerpos"; //common api
	

	public static deleteCustomer=AppSettings.API_BASE + "/customer/deletecustomer/"; //Delete specific Customer
	public static updateCustomer= AppSettings.API_BASE + "/customer/update/"; //Update Specific user
	public static Customerdropdown= AppSettings.API_BASE + "/customer/getcustomerdropdown"; //Update Specific user
	public static Customername= AppSettings.API_BASE + "/customer/getcustomername";
	public static Customerstorename= AppSettings.API_BASE + "/customer/getcustomerstorename";
	public static Customergst= AppSettings.API_BASE + "/customer/getcustomergst";
	public static FilterCustomerlist=AppSettings.API_BASE + "/customer/filtercustomer"; //Customer list
	public static RouteList=AppSettings.API_BASE + "/customer/routelist"; //Customer list

	//Manage Customer Api Ends here

	//Manage Customer Type Api Starts here
	public static Customertypecommon=AppSettings.API_BASE + "/customertype"; //common api
	//Manage Customer Type Api Ends here

	//Manage Company Api Starts here
	public static Companycommon=AppSettings.API_BASE + "/company"; //common api
	public static getCompanylist=AppSettings.API_BASE + "/company/getcompany"; //Company list
	public static deleteCompany=AppSettings.API_BASE + "/company/deletecompany/"; //Company list
	public static updateCompany= AppSettings.API_BASE + "/company/update/"; //Update Specific company
	//Manage Company Api Ends here
	public static Closurereportcommon = AppSettings.API_BASE + "/closurefilter"; //common api
	//Manage Category Api Starts here
	public static Categorycommon=AppSettings.API_BASE + "/category"; //common api
	public static getCategorylist=AppSettings.API_BASE + "/category/getcategory"; //Category list
	public static deleteCategorylist=AppSettings.API_BASE + "/category/deletecategory/"; //API Delete Call URL
	public static insertCategorylist=AppSettings.API_BASE + "/category/insert"; //API Insert Call URL
	//Manage category Api Ends here


	//Manage State Api Starts here
	public static Statecommon=AppSettings.API_BASE + "/state"; //common api
	public static GetState=AppSettings.API_BASE + "/state/getstate"; //common api
	public static DeleteState = AppSettings.API_BASE + "/state/deletestate"; //common api
	
	//Manage State Api Ends here


	//Manage Sub Category Api Starts here
	public static subCategorycommon=AppSettings.API_BASE + "/subcategory"; //common api
	public static getsubCategorylist=AppSettings.API_BASE + "/subcategory/getsubcategory"; //API Call URL
	public static getsubCatlist = AppSettings.API_BASE + "/subcategory/getsubcat"; //API Call URL
	public static deletesubCategorylist=AppSettings.API_BASE + "/subcategory/deletesubcategory/"; //API Delete Call URL
	public static getSubcategorylist=AppSettings.API_BASE + "/subcategory/getsubcategorybyid"; //API Insert Call URL
	//Manage Sub category Api Ends here

	//warehousebin   API starts here
	public static getwarehousebincommon = AppSettings.API_BASE + "/warehousebin"; //common api
	public static getwarehousebin = AppSettings.API_BASE + "/warehousebin/getwarehousebin"; //get list of departments
	public static delwarehousebin = AppSettings.API_BASE + "/warehousebin/deletewarehousebin/"; //delete specific departments
	public static addwarehousebin = AppSettings.API_BASE + "/warehousebin/addwarehousebin/"; //get list of departments
	public static findwarehousebin = AppSettings.API_BASE + "/warehousebin/findwarehousebin/"; //Find warehousebin with id's
	public static deleterackbin = AppSettings.API_BASE + "/warehousebin/deleterackbin/"; //Activate or deactivate api
	public static findisdeletedrack = AppSettings.API_BASE + "/warehousebin/findbinstatus/"; //edit id find is_deleted racks
	public static findbinbyid = AppSettings.API_BASE + "/warehousebin/findbinbyid/"; //Find warehouse bin by id
	public static findactiveordeactive = AppSettings.API_BASE + "/warehousebin/findactiveordeactive/"; //Find warehouse Active or Deactive
	public static checkrack = AppSettings.API_BASE + "/warehousebin/checkrack/"; //delete specific departments
	
	//warehousebin  API ends here

	//Godown API starts here
	public static getgodowncommon = AppSettings.API_BASE + "/godown"; //common api
	public static getgodown = AppSettings.API_BASE + "/godown/getgodown"; //get list of godown
	public static deletegodown = AppSettings.API_BASE + "/godown/deletegodown/"; //delete specific godown
	public static updategodown= AppSettings.API_BASE + "/godown/update/"; //Update Specific godown
	public static getgodowndetail= AppSettings.API_BASE + "/godown/getgodowndetail"; //Update Specific godown
	public static getgodownlist= AppSettings.API_BASE + "/godown/getgodownlist"; //Update Specific godown
	public static getgodownvalid= AppSettings.API_BASE + "/godown/getgodownvalid"; //Valid godown is_deleted=0
	public static godwnstockcheck= AppSettings.API_BASE + "/godown/godwnstockcheck/"; //Godown check status in stock
	public static floorstockcheck= AppSettings.API_BASE + "/godown/floorstockcheck/"; //Floor check status in stock

	//Godown  API ends here

	//Floor API starts here
	public static getfloorcommon = AppSettings.API_BASE + "/floor"; //common api
	public static getfloor = AppSettings.API_BASE + "/floor/getfloor"; //get list of floor
	public static deletefloor = AppSettings.API_BASE + "/floor/deletefloor/"; //delete specific floor
	public static updatefloor= AppSettings.API_BASE + "/floor/update/"; //Update Specific floor
	public static getfloordata= AppSettings.API_BASE + "/floor/getfloors"; //Get Specific floor list
	public static insertfloordata= AppSettings.API_BASE + "/floor/insertfloor"; //Insert floor list
	public static editfloordata = AppSettings.API_BASE + "/floor/editfloordata"; //edit floor data of floor
	public static getfloorlistcommon = AppSettings.API_BASE + "/floor/getfloorlist"; //edit floor data of floor
	public static getfloorhasrack = AppSettings.API_BASE + "/floor/floorhasrack"; //Floor has rack list
	//Floor  API ends here


	//Vehicle API starts here
	public static getvehiclecommon = AppSettings.API_BASE + "/vehicle"; //common api
	public static getvehicle = AppSettings.API_BASE + "/vehicle/getvehicle"; //get list of vehicle
	public static getopwvehicle = AppSettings.API_BASE + "/vehicle/getopwvehicle"; //get list of vehicle based on op and wp

	
	public static deletevehicle = AppSettings.API_BASE + "/vehicle/deletevehicle/"; //delete specific vehicle
	public static updatevehicle= AppSettings.API_BASE + "/vehicle/update/"; //Update Specific vehicle
	//Vehicle API ends here


	//Product Image Upload
		public static productupload= AppSettings.API_BASE + "/imageupload/upload"; //Update Specific 

	//Customer Image Upload

		public static customerupload= AppSettings.API_BASE + "/imageupload/upload"; //Update Specific 

		public static customerwebupload= AppSettings.API_BASE + "/imageupload/customerupload"; //Update Specific 

	// Sales Rep Image Upload
		public static salesrepwebupload= AppSettings.API_BASE + "/imageupload/salesrepwebupload"; //Update Specific 

	// Customer Group API starts

		public static customergroupcommon= AppSettings.API_BASE + "/customergroup"; //Common API
		public static customergroupinsert= AppSettings.API_BASE + "/customergroup/insert"; //Common API
		public static customergroupupdate= AppSettings.API_BASE + "/customergroup/cgroupupdate"; //Common API
		
		
		public static getcustomergrouplist=AppSettings.API_BASE + "/customergroup/getcustomergroup"; //API Call URL
		public static deletecustomergrouplist=AppSettings.API_BASE + "/customergroup/deletecustomergroup/"; //API Delete Call URL
		public static getRoutelist=AppSettings.API_BASE + "/routes/getroutelist"; //API Call URL
		
	// Discount Master API starts

		public static discountcommon= AppSettings.API_BASE + "/discount"; //Common API
		public static getdiscountlist=AppSettings.API_BASE + "/discount/getdiscount"; //API Call URL
		public static getdiscountlistbygroup=AppSettings.API_BASE + "/discount/getdiscountbygroup"; //API Call URL
		public static discountlog=AppSettings.API_BASE + "/discount/insertdiscountlog";
		public static getdiscountloglist=AppSettings.API_BASE + "/discount/getlog";
		
		

		public static deletediscountlist=AppSettings.API_BASE + "/discount/deletediscount"; //API Delete Call URL
		public static updateDiscount= AppSettings.API_BASE + "/discount/update/"; //Update Specific discount
		public static CheckDiscount = AppSettings.API_BASE + "/discount/checkdiscount/"; //check Specific discount
		public static GetIndivialProductDiscount = AppSettings.API_BASE + "/discount/getproductdiscount/"; //get individual product discount as per customer
		public static GetCustomerDiscount = AppSettings.API_BASE + "/discount/getcustomerdiscount/"; //get individual product discount as per customer

	//Route vs Customer relation api starts here
		public static Routecustomer= AppSettings.API_BASE + "/routecustomer/insertroutecustomer"; //Route Customer common api
		public static Routecustomerbyid= AppSettings.API_BASE + "/routecustomer/getroutebyid/"; //Route Customer by Id
		public static Insertassigncustomer= AppSettings.API_BASE + "/routecustomer/insertassigncustomer/"; //Insert Assign Customer by Id
		public static Getroutecustomer= AppSettings.API_BASE + "/routecustomer/getroutebycustomer/"; //Insert Assign Customer by Id
		public static updateroutecustomer= AppSettings.API_BASE + "/routecustomer/updateroutecustomer/"; //Update Assign Customer by Id



	//Route vs Customer relation api Ends here

	public static getRoutes= AppSettings.API_BASE + "/routes/getroutes/"; //Route common api
	public static ActiveRoutes= AppSettings.API_BASE + "/routes/activeroutes/"; //Route common api
	public static viewRoutes= AppSettings.API_BASE + "/routes/viewroutes/"; //view Route common api
	public static addRoute= AppSettings.API_BASE + "/routes/insertroute/"; //view Route common api
	public static deleteroute=AppSettings.API_BASE + "/routes/deleteroute/";//delete the Route
	public static editroute=AppSettings.API_BASE + "/routes/editroute/";//edit the Route
	public static updateroute=AppSettings.API_BASE + "/routes/updateroute/";//update the Route
	public static Routebyid=AppSettings.API_BASE + "/routes/routebyid/";//Get Route by ID
	public static getRoutebyid=AppSettings.API_BASE + "/routes/getroute/";//Get Route and customer by ID
	public static DeleteRoutebyid = AppSettings.API_BASE + "/routes/deleteroutebyid/";//Get Route by ID
	

	//Sidebar menu api with module names starts here
	public static Sidebarmenulist= AppSettings.API_BASE + "/sidebarmenu"; //Sidebar menu list common api /sidebarmenu
	public static Menumodulelist= AppSettings.API_BASE + "/sidebarmenu/menumodulelist"; //Sidebar menu Module list common api
	public static Sidebarmenuparentlist= AppSettings.API_BASE + "/sidebarmenu/sidemenuparent"; //Sidebar menu Parent list /sidebarmenuparent
	public static menuchildlist= AppSettings.API_BASE + "/sidebarmenu/menuchildlist"; // Menu Child List api
	//Sidebar menu api with module names ends here


	// Stock Master API starts

	public static stockcommon= AppSettings.API_BASE + "/stock"; //Common API
	public static getstocklist=AppSettings.API_BASE + "/stock/getstock"; //API Call URL
	public static deletestocklist=AppSettings.API_BASE + "/stock/deletestock"; //API Delete Call URL
	public static updatestock= AppSettings.API_BASE + "/stock/update/"; //Update Specific stock
	public static getracklist= AppSettings.API_BASE + "/stock/getrack/"; //Get rack Specific stock
	public static getracklists= AppSettings.API_BASE + "/stock/fetchrack"; //Get rack Specific stock
	public static GetRackLists = AppSettings.API_BASE + "/stock/rack"; //Get rack Specific stock
	public static GetRackByDetails = AppSettings.API_BASE + "/stock/getrackbydetail"; //Get rack Specific stock
	public static updatestockoverall= AppSettings.API_BASE + "/stock/updatestock"; //Update Stock and value change in overall stock
	public static updatestocklist= AppSettings.API_BASE + "/stock/updateoverallstock"; //Update Stock and value change in overall stock
	


	public static getrackmultilists= AppSettings.API_BASE + "/productrackmap/getrackmulti"; //Get rack Specific stock
	public static insertrackmultilists= AppSettings.API_BASE + "/productrackmap/insertproductrack"; //Get Insert Product rack Mapping
	public static GetProductRackDetails= AppSettings.API_BASE + "/productrackmap/getproductrackdetail"; //Get rack by product
	public static GetOWProductRackDetails= AppSettings.API_BASE + "/productrackmap/getowproductrackdetail"; //Get rack by product
	
	public static GetRackByproduct= AppSettings.API_BASE + "/productrackmap/getrackbyproduct"; //Get rack by product
	public static stockproductlist= AppSettings.API_BASE + "/stock/getproductname";
	public static stockgodownlist= AppSettings.API_BASE + "/stock/getgodownname";
	public static stockfloorlist= AppSettings.API_BASE + "/stock/getfloorname";
	public static FilterStocklist=AppSettings.API_BASE + "/stock/filterstock"; //Filter stock list
	public static GetstockNotificationByRack = AppSettings.API_BASE + "/stock/getstockbyrack"; //Filter stock list
	public static Getsoldstocklist=AppSettings.API_BASE + "/stock/getsoldstock"; //Filter stock list
	public static GetsoldstockFilter=AppSettings.API_BASE + "/stock/getsoldstockfilterreport"; //Filter stock list

	//overall stock list starts here

	public static overallstockcommon= AppSettings.API_BASE + "/overallstock"; //Common API
	public static insertoverallstock= AppSettings.API_BASE + "/overallstock/insertoverallstock/"; //Common API
	public static getoverallstock= AppSettings.API_BASE + "/overallstock/getoverallstock"; //Common API
	public static getstockdetail= AppSettings.API_BASE + "/overallstock/getstockdetail"; //Common API get stock detail
	public static getselectedstock= AppSettings.API_BASE + "/overallstock/getselectedstock"; //Common API get selected stock detail

	//overall stock list ends here


	//Order Master API starts here

	public static getorders=AppSettings.API_BASE + "/orders"; //API Call URL
	public static InsertOrder = AppSettings.API_BASE + "/orders/insertorder"; //API Call URL
	public static getorderslist=AppSettings.API_BASE + "/orders/getorderslist"; //API Call URL
	public static getcancelorderslist=AppSettings.API_BASE + "/orders/getcancelorderslist"; //API Call URL
	public static getselectedorderslist=AppSettings.API_BASE + "/orders/getselectedorder"; //API get selected order list
	public static getdordersstatus=AppSettings.API_BASE + "/orders/getorderstatus/"; //API get orders status master
	public static deleteorder=AppSettings.API_BASE + "/orders/deleteorder"; //API get orders status master
	public static getorderinfo=AppSettings.API_BASE + "/orders/get_order_info"; //API get orders detail master
	public static CheckOrderStock = AppSettings.API_BASE + "/orders/check_order_stock/"; //API Check Order Invoiced 
	public static UpdateOrder = AppSettings.API_BASE + "/orders/update_order/"; //API Check Order Invoiced 
	public static updateorderstatus=AppSettings.API_BASE + "/orders/update_order_status/"; //API update orders status master

	public static updateorderdispatchstatus=AppSettings.API_BASE + "/orders/update_dispatch_process_status/"; //API update orders dispatch status master
	public static checkorderinvoiced=AppSettings.API_BASE + "/orders/check_invoiced_order/"; //API Check Order Invoiced 

	public static Holdpos=AppSettings.API_BASE + "/orders/holdpos"; //Hold POS
	public static Getposlist=AppSettings.API_BASE + "/orders/getholdpos"; //Get POS data
	public static Getposholddata=AppSettings.API_BASE + "/orders/getholddatabyid"; //get hold data by id
	public static insertlog = AppSettings.API_BASE + "/orders/insertlog"; //get hold data by id
	public static gertorderlog = AppSettings.API_BASE + "/orders/getorderlog"; //get hold data by id
	

	//code ends here


	//Approve completed picklist by sales manager api
	public static getcompletedpicklist=AppSettings.API_BASE + "/orders/getcompletedpicklist"; //API Call URL
	public static getselectedpicklist=AppSettings.API_BASE + "/orders/getselectedpicklist/"; //API get selected order list
	public static getorderinfo2=AppSettings.API_BASE + "/orders/get_order_alloted_info"; //API get orders detail master
	public static updateorderpickliststatus=AppSettings.API_BASE + "/orders/update_order_process_status/"; //API update orders status master
	public static updatemuiltipleorderstatus=AppSettings.API_BASE + "/orders/update_muiltiple_order_process_status/"; //API update orders status master




	//get picklist api starts here
	public static getpicklists=AppSettings.API_BASE + "/orders/getorderspicklist"; //API Call URL
	public static getpicklistorderinfo=AppSettings.API_BASE + "/orders/get_pick_list_order_info"; //API get orders detail master
	public static updateorderstatusconfirm=AppSettings.API_BASE+"/orders/update_picklist_order_status";
	public static getrackallotedlist=AppSettings.API_BASE + "/orders/get_rack_alloted_info"; //API get orders dispatch detail master
	public static getpicklistcompleted=AppSettings.API_BASE + "/orders/getpicklistcompleted/"; //API get completed picklist for warehouse manager

	//Master Indents
	public static indentrequestinsert=AppSettings.API_BASE + "/indentrequest/insert_indent_list/"; //API Indents Request Insert
	public static listindentrequests=AppSettings.API_BASE + "/indentrequest/list_requests/"; //API Call Master Indents
	public static indentapprove = AppSettings.API_BASE + "/indentrequest/approveindent/"; //delete specific departments
	public static getindentinfo=AppSettings.API_BASE + "/indentrequest/get_indent_list_order_info"; //API get orders detail master
	public static Requeststocklist=AppSettings.API_BASE + "/indentrequest/listrequeststock"; //API get Indent Request Stock
	public static Requeststocklistinfo=AppSettings.API_BASE + "/indentrequest/indent_request_list_info"; //API get Indent Request Stock Info
	
	public static Returnindentstock=AppSettings.API_BASE + "/indentrequest/returnindentstock"; //API Return Indent Stock
	public static Returnindentstocklist=AppSettings.API_BASE + "/indentrequest/list_return_list/"; //API Return Indent list
	public static Viewreturnstocklist=AppSettings.API_BASE + "/indentrequest/get_return_list_info"; //API Return Indent list View
	public static Approvereturnstocklist=AppSettings.API_BASE + "/indentrequest/approvereturnstock"; //API Return Indent list Approve
	public static Approvereturnstockinsertion=AppSettings.API_BASE + "/indentrequest/approvereturnstockinsertion"; //API Return Indent list insert on stock
	public static Cancelreturnstock=AppSettings.API_BASE + "/indentrequest/cancelreturnstock"; //API Return Indent list Cancel
	
	public static Getreturnlog=AppSettings.API_BASE + "/indentrequest/getreturnlog"; //API Return Indent log
	public static Filterreturnlog=AppSettings.API_BASE + "/indentrequest/filterreturnlist"; //API Filter Return Indent log
	
	//Approved Indent

	public static Approvedlistrequests=AppSettings.API_BASE + "/approvedindent/approvedlist/"; //API Call Master Indents
	public static approval = AppSettings.API_BASE + "/approvedindent/indentapprove/"; //delete specific departments
	public static indentlistinfo=AppSettings.API_BASE + "/approvedindent/indent_list_info"; //API get orders detail master
	public static Stockindentcheck=AppSettings.API_BASE + "/approvedindent/check_stock"; //API get orders detail master
	public static updateindentstatusconfirm=AppSettings.API_BASE+"/approvedindent/update_indent_picklist_status";



	//Transport   API starts here
	public static getTransportcommon = AppSettings.API_BASE + "/transport"; //common api
	public static getTransport = AppSettings.API_BASE + "/transport/gettransport"; //get list of transport
	public static delTransport = AppSettings.API_BASE + "/transport/deletetransport/"; //delete specific transport
	//Transport  API ends here


	//invoice API starts here

	public static getApprovedorders=AppSettings.API_BASE + "/orders/getapprovedorders"; //API Call URL
	public static generateInvoice=AppSettings.API_BASE + "/orders/generateinvoice/"; //API generate invoice
	public static getselectedorderlist=AppSettings.API_BASE + "/orders/getselectedorderlist/"; //API get selected order list
	public static getinvoiceinfo=AppSettings.API_BASE + "/orders/getselectedorderinvoice/"; //API get selected order invoices
	public static downloadinvoiceinfo=AppSettings.API_BASE + "/orders/downloadinvoice/"; //API download invoice

	public static getinvoicelist=AppSettings.API_BASE + "/orders/getinvoicedorderslist"; //API Call URL
	public static getposupdatedinvoicelist=AppSettings.API_BASE + "/pos/getposinvoicedlist"; //API Call URL
	public static getinvoicetypes=AppSettings.API_BASE + "/orders/getinvoicetype"; //API Call URL

	public static addeaybill=AppSettings.API_BASE + "/orders/addeaybill"; //API Call URL for add eway bill

	public static getinvoiceall=AppSettings.API_BASE + "/orders/getinvoice"; //API Call URL

	public static adddespatch=AppSettings.API_BASE + "/orders/adddespatch"; //API Call URL for add despatch list
	public static CancelInvoice = AppSettings.API_BASE + "/orders/cancelinvoice"; //API Call URL for add despatch list
	public static ApproveCancelInvoice = AppSettings.API_BASE + "/orders/approvecancelinvoice"; //API Call URL for approve cancelled invoice

	public static CancelledInvoiceList = AppSettings.API_BASE + "/orders/cancelledinvoicelist"; //API Call URL
	public static GetCancelledInvoiceInfo = AppSettings.API_BASE + "/orders/getcancelledinvoicedetails/"; //API get selected order invoices



	//invoice API ends here


	//Master Completed Indents

	public static CompletedList=AppSettings.API_BASE + "/completedindent/list_requests/"; //API Call Master Indents
	public static ViewIndent = AppSettings.API_BASE + "/completedindent/viewcompletedindent/";


	//Manage GST Api Starts here
	public static gstcommon=AppSettings.API_BASE + "/gst"; //common api
	public static gstlist=AppSettings.API_BASE + "/gst/getgst"; //GST list
	public static editgst=AppSettings.API_BASE + "/gst/editgst"; //GST item list
	public static deletegst=AppSettings.API_BASE + "/gst/deletegst/"; //GST list
	public static updategst= AppSettings.API_BASE + "/gst/update/"; //Update Specific GST
	//Manage GST Api Ends here

	//Manage Category Api Starts here
	public static ExpenseCategorycommon=AppSettings.API_BASE + "/expensecategory"; //common api
	public static getExpenseCategorylist=AppSettings.API_BASE + "/expensecategory/getcategory"; //Category list
	public static deleteExpenseCategory=AppSettings.API_BASE + "/expensecategory/deletecategory"; //API Delete Call URL
	//Manage category Api Ends here

	//Manage Expense Api Starts here
	public static Expensecommon=AppSettings.API_BASE + "/expense"; //common api
	public static getExpenselist=AppSettings.API_BASE + "/expense/getexpense"; //Company list
	public static deleteExpense=AppSettings.API_BASE + "/expense/deleteexpense"; //Company list
	public static updateExpense= AppSettings.API_BASE + "/expense/update/"; //Update Specific expense
	//Manage Expense Api Ends here

	// Manage Rack Cam
	public static rackcamcommon = AppSettings.API_BASE + "/rackcam"; //common api
	public static getrackcamlist = AppSettings.API_BASE + "/rackcam/getrackcamlist";
	public static deleterackcam=AppSettings.API_BASE + "/rackcam/deleterackcam"; //Company list
	public static checkracklist = AppSettings.API_BASE + "/rackcam/checkrack";

	// Manage Sales Rep Routes
	public static RepRoutecommon = AppSettings.API_BASE + "/salesreproute"; //common api
	public static RepAllotedRoute = AppSettings.API_BASE + "/salesreproute/salesrepallotedroutes"; //common api
	public static RouteApprove = AppSettings.API_BASE + "/salesreproute/routeapprove"; //common api

	//Manage Sales Rep Report File
	public static RepReportcommon = AppSettings.API_BASE + "/salesrepreport"; //common api
	public static Getchallancommon = AppSettings.API_BASE + "/salesrepreport/getchallan"; //common api
	public static Getchallanbyid = AppSettings.API_BASE + "/salesrepreport/getchallanbyid"; //Get challan data by id
	

	// Manage Invoice Setting
	public static Settingcommon = AppSettings.API_BASE + "/invoicesetting"; //common api
	public static insertAllSetting = AppSettings.API_BASE + "/invoicesetting/insert"; //common api
	public static getAllSetting = AppSettings.API_BASE + "/invoicesetting/getallsettings"; //common api
	public static CheckSetting = AppSettings.API_BASE + "/invoicesetting/checksetting"; //common api
	public static CheckSettingDataExist = AppSettings.API_BASE + "/invoicesetting/checksettingdataexist"; //common api
	
	public static DeleteSetting = AppSettings.API_BASE + "/invoicesetting/deletesetting"; //common api

	// Manage Dynamic Rack
	public static DynamicRackcommon = AppSettings.API_BASE + "/dynamicrack"; //common api
	public static getAllDynamicRack = AppSettings.API_BASE + "/dynamicrack/getalldynamicrack"; //common api
	public static DynamicRack = AppSettings.API_BASE + "/dynamicrack/dynamicrack"; //common api
	public static checkRack = AppSettings.API_BASE + "/dynamicrack/checkrack"; //common api
	public static GetRackname = AppSettings.API_BASE + "/dynamicrack/getRackname"; //common api GetRackname
	public static DeleteDynamicRack = AppSettings.API_BASE + "/dynamicrack/deletedynamicrack"; //common api
	

	// Manage Sales No
	public static Salescommon = AppSettings.API_BASE + "/salesno";

	//Company Image Upload
	public static CompanyUpload= AppSettings.API_BASE + "/imageupload/companyupload"; //Update Specific vehicle

	// Track Sales Rep
	public static SalesRep= AppSettings.API_BASE + "/tracksalesrep/getsalesrep"; //Update Salesrep tracking
	public static SalesRepRoutes= AppSettings.API_BASE + "/tracksalesrep/viewroutes/"; //view Route common api

	//Notification
	public static notifications= AppSettings.API_BASE + "/notification/getnotificationslist"; //view all notification common api
	public static insertnotification= AppSettings.API_BASE + "/notification/insertnotification"; //insert notification
	public static insertmultiplenotify= AppSettings.API_BASE + "/notification/insertmultiplenotify"; //insert multiple notification
	public static updatenotifications= AppSettings.API_BASE + "/notification/updatenotification"; //update notification
	public static allnotifications= AppSettings.API_BASE + "/notification/allnotifications"; //all notification
	public static Dashboardlistnotifications= AppSettings.API_BASE + "/notification/dashboardlistnotifications"; //all notification

	// Voucher manage
	public static AddVoucher= AppSettings.API_BASE + "/voucher/addvoucher"; //Add Voucher
	public static GetVoucher= AppSettings.API_BASE + "/voucher/getvoucher"; //Get Voucher Details
	public static DeleteVoucher= AppSettings.API_BASE + "/voucher/deletevoucher"; //Delete Voucher
	public static VoucherDetail= AppSettings.API_BASE + "/voucher/voucherdetail"; //Delete Voucher

	// Report Module
	public static GetOrdersReport=AppSettings.API_BASE + "/reports/getordersreport"; //API Call URL
	public static FilterOrdersList=AppSettings.API_BASE + "/reports/filterorders"; //API get selected order list
	public static GetStockReport= AppSettings.API_BASE + "/reports/getstockreport"; //Common API
	public static GetProduct= AppSettings.API_BASE + "/reports/getproduct"; //Common API
	public static GetLedgerReport = AppSettings.API_BASE + "/reports/getledgerreport"; //Common API
	public static GetSalesReport=AppSettings.API_BASE + "/reports/getsalesreport"; //API Call URL
	public static FilterSalesList = AppSettings.API_BASE + "/reports/filtersales"; //API get selected order list
	public static FilterCustomerList = AppSettings.API_BASE + "/reports/getcustomerfilterlist"; //API get customer list
	public static getFilterSalesListApiUrl = AppSettings.API_BASE + "/reports/getsalesfilterlist"; //API get customer list
	public static getClosureReportApiUrl = AppSettings.API_BASE + "/reports/getclosurereport"; //API get closure report
	public static checkRepHasstock = AppSettings.API_BASE + "/reports/checkstock"; //API get closure report
	public static addFilterdata = AppSettings.API_BASE + "/reports/savefilterdata"; //API get closure report
	
	
	public static getClosureFilterReportApiUrl = AppSettings.API_BASE + "/reports/filterclosurereport"; //API get closure report

	public static getorderreportinfo = AppSettings.API_BASE + "/orders/get_order_report_info"; //API get orders detail master
	public static getSalesByList = AppSettings.API_BASE + "/reports/getsalesbylist"; //API get salesby  dropdown list

	public static FilterChallanList=AppSettings.API_BASE + "/reports/filterchallan"; //API get selected order list

	// Switch Warehouse
	public static UpdateWarehouseSwitch=AppSettings.API_BASE + "/dashboard/switchwarehouseupdate"; //API Call URL
	public static salesreport=AppSettings.API_BASE + "/dashboard/getsalereport"; //sales report API Call URL

	public static customer = AppSettings.API_BASE + "/customer/customer"; //Customer list based on chennai operation
	public static CustomerServe = AppSettings.API_BASE + "/customer/customerserve"; //Customer list based on chennai operation
	public static AddRequestOrder = AppSettings.API_BASE + "/requestorder/insertrequest"; //Insert Request order based on chennai operation
	public static GetRequestOrder = AppSettings.API_BASE + "/requestorder/getrequestorderlist"; //get all request order based on chennai operation
	public static GetCustomerList = AppSettings.API_BASE + "/customer/customerlist";
	public static UpdateLatLong = AppSettings.API_BASE + "/customer/updatelatlng"; //update customer location

	public static SearchCategory = AppSettings.API_BASE + "/category/searchcategory"; //sales report API Call URL

	public static OnhandQuantity = AppSettings.API_BASE + "/product/getonhandquantity"; // 
	

	public static SearchProduct = AppSettings.API_BASE + "/product/searchproduct"; //sales report API Call URL
	// Setting Master
	public static AddSetting = AppSettings.API_BASE + "/settingmaster";
	public static GetSetting = AppSettings.API_BASE + "/settingmaster/getsetting";

	// Stock Indication Dashboard
	public static GetStockIndicationList = AppSettings.API_BASE + "/overallstock/stockindicatonlist";
	public static GetStockIndicationListForTop = AppSettings.API_BASE + "/overallstock/stockindicatonlistfortopnav";
	public static GetStockOveralllist =  AppSettings.API_BASE + "/overallstock/overallstocklist";

	public static ClosureReportlist = AppSettings.API_BASE + "/reports/getclosurefilterreport";

		// POS Module
	public static InsertPos = AppSettings.API_BASE + "/pos/insertpos";
	public static getposinvoicelist = AppSettings.API_BASE + "/pos/getposinvoicelist";
	public static filterposinvoicelist = AppSettings.API_BASE + "/pos/filterposinvoice";
	public static posCustomerList = AppSettings.API_BASE + "/pos/getcustomerlist";
	


	//Estimation Master
	public static InsertEstimation = AppSettings.API_BASE + "/estimation/addestimation";
	public static GetEstimationList = AppSettings.API_BASE + "/estimation/getestimatelist";
	public static GetEstimationItems = AppSettings.API_BASE + "/estimation/get_estimate_items_info";
	public static UpdateEstimateScPercentage = AppSettings.API_BASE + "/estimation/update_estimate_sc_percentage";
	public static GetEstimationProduct = AppSettings.API_BASE + "/product/getestinationproduct";
	public static SearchEstimationProducts = AppSettings.API_BASE + "/product/searchestimationproduct";



	public static Converttoorder=AppSettings.API_BASE + "/orders/converttoorder"; //Convert to order from estimation
	
	
	//pos sales report

	public static getpossalesreport = AppSettings.API_BASE + "/reports/possalesreport"; //API get B2B Report

	//B2B Report
	public static Getb2breport = AppSettings.API_BASE + "/reports/getb2breport"; //API get B2B Report
	public static Getb2breportdata = AppSettings.API_BASE + "/reports/getb2breportdata"; //API get B2B Report
	public static Filterb2breportdata = AppSettings.API_BASE + "/reports/filterb2b"; //API Filter B2B Report

	//B2C Report
	public static Getb2creport = AppSettings.API_BASE + "/reports/getb2creport"; //API get B2C Report
	public static Getb2creportdata = AppSettings.API_BASE + "/reports/getb2creportdata"; //API get B2C Report
	public static Filterb2creportdata = AppSettings.API_BASE + "/reports/filterb2c"; //API Filter B2C Report

	//B2C Report
	public static Getb2csreport = AppSettings.API_BASE + "/reports/getb2csreport"; //API get B2CS Report
	public static Getb2csreportdata = AppSettings.API_BASE + "/reports/getb2csreportdata"; //API get B2CS Report
	public static Filterb2csreportdata = AppSettings.API_BASE + "/reports/filterb2cs"; //API Filter B2CS Report

	//Manage Transport Api Starts here
	public static Transportcommon  = AppSettings.API_BASE + "/managetransport"; //common api
	public static getTransportlist = AppSettings.API_BASE + "/managetransport/gettransport"; //Transport list
	public static getTransportData = AppSettings.API_BASE + "/managetransport/gettransportdata"; //Transport list
	public static UpdateTransportData = AppSettings.API_BASE + "/managetransport/updateordertransport"; //Transport list
	public static UpdateInvoiceTransportData = AppSettings.API_BASE + "/managetransport/updateinvoicetransport"; //Transport list
	
	public static deleteTransport  = AppSettings.API_BASE + "/managetransport/deletetransport"; //Transport list
	public static updateTransport  = AppSettings.API_BASE + "/managetransport/update/"; //Update Specific Transport
	//Manage Transport Api Ends here

	public static AdvsettingCommon = AppSettings.API_BASE + "/advsetting";
	public static AdvsettingInsertCommon = AppSettings.API_BASE + "/advsetting/insert";
	public static GetAdvsetting = AppSettings.API_BASE + "/advsetting/getadvsetting";
	public static StockProductFilter = AppSettings.API_BASE + "/product/stockproductfilter";
	public static ProductRackList = AppSettings.API_BASE + "/product/getproductracklist";
	

	// Manage Transit
	public static getTransitcommon = AppSettings.API_BASE + "/transit"; //common api
	public static getTransit = AppSettings.API_BASE + "/transit/gettransit"; //get list of transit
	public static getTransitData = AppSettings.API_BASE + "/transit/gettransitdata"; //transit list
	public static delTransit = AppSettings.API_BASE + "/transit/deletetransit"; //delete specific transit
	public static UpdateInvoiceTransitData = AppSettings.API_BASE + "/transit/updateinvoicetransit"; //Transit list

}