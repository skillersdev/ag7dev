import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import { TranslateService } from '@ngx-translate/core';
import Swal from 'sweetalert2'

declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})



export class DashboardComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  details_array:any=[];
  currentAllUsers:any;
  tamount:any;
  payment_details:any
  packagelist:Array<Object>;
  package_vs_user_list:Array<Object>;
  model: any = {};
  elearningmodel:any={};
  alldata: any = {};
  payment_data:any={};
  transferdata: any = {};
  renew_payment_details:any=false;
  select: any;
  isPaid:Boolean=false;
  userwebsiteurl:string=AppSettings.userweburl;
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  checkIswebsite:Boolean=false;
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  checkpackageisactivated:string = AppSettings.packageisactivated; 
  checkUserCreditRestApiUrl:string = AppSettings.checkusercredit;
  inserttrasnfeprocessRestApiUrl:string = AppSettings.inserttransferprocess;
  getpackagevsuserApiUrl:string = AppSettings.getPackageNotbuy;
  insertpackagevsuserApiUrl:string = AppSettings.insertpackagevsuser;
  packageActivateApiUrl:string = AppSettings.PACKAGE_ACTIVATE;
  showButton:Boolean=false;

  websiteurl:string=AppSettings.USER_TEMPLATE;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http,private translate:TranslateService) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.renew_payment_details=true;
    this.showButton=false;

    let id=localStorage.getItem('currentUserID');
      this.CommonService.editdata(this.checkpackageisactivated,id).subscribe(data=>{
         if(data.exist==2)
          {
           
           this.router.navigate(['./packageinfo']); 
          }
      });
       let user_id = localStorage.getItem('currentUserID');
       this.tamount = localStorage.getItem('tamount');
       this.model.user_id = user_id;
      this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
          .subscribe(resultdata =>{   
            this.packagelist=resultdata.result; 
            this.model.tot_amt=resultdata.result[0]['tamount']; 
            this.model.e_amt=resultdata.result[0]['eamount']; 
                      });

      this.CommonService.editdata(this.getpackagevsuserApiUrl,user_id)
          .subscribe(resultdata =>{   
            this.package_vs_user_list=resultdata.result; 
          });    
  
    let translate_url="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    
    if(localStorage.getItem('languageType'))
    {
      var stringLang = localStorage.getItem('languageType');
      this.switchLang(stringLang);
    }else{
      this.switchLang('English');
    }
    
  }

  public loadScript(url) {
    console.log('preparing to load...')
    let node = document.createElement('script');
    node.src = url;
    node.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(node);
  }

  logout(){
    this.loginService.logout();
  }
  switchLang(lang: string) {    
    this.translate.use(lang);
    localStorage.setItem('languageType',lang);
  }
  // p
 checkmarketer(marketer_name:any)
 {
   this.model.username=marketer_name;
   this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model).subscribe(data=>{
      if(data.exist==0)
      {                
         swal('Oops...','Marketer doesnot exists', 'error');
         this.model.mname='';
      }       
    });
  }
  pay_via_voucher()
  {
    this.payment_details=true;
    
  }
  pay_via_voucher_renew()
  {
    this.renew_payment_details=false;
  }
  savepackages()
  {
    this.CommonService.insertdata(this.insertpackagevsuserApiUrl,this.model)
    .subscribe(package_det =>{   
      if(package_det.status==1)
      {
        Swal.fire({
          title: 'Package has been alloted',
          type: 'success',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Activate Package now?'
        }).then((result) => {
          if (result.value) {
            this.router.navigate(['/packageinfo']);
          }
        })
           $('#largeModal').modal('toggle');
      } else{
        swal('Oops...',package_det.message, 'error');
      }   
        
        //this.router.navigate(['/dashboard']) ; 
    });
  }
  checkbalance(type:any)
  {     
    this.alldata.user_id=localStorage.getItem('currentUserID');
    this.model.share_amt = (type==1)?this.model.share_amt:this.elearningmodel.share_amt;
    this.alldata.shareType = type;
    if((this.model.share_amt!='')&&(this.model.share_amt!=undefined))
      {
        this.alldata.share_amt=this.model.share_amt;
        this.CommonService.checkexistdata(this.checkUserCreditRestApiUrl,this.alldata).subscribe(data=>{
          if(data.total_amount<=50)
          {                
             swal('Oops...','Minimum Amount should be more than 50', 'error');
             this.model.share_amt='';
          }
          else{
            if(data.status==1)
            {
               swal('Oops...',data.message, 'error');
               this.model.share_amt=''; 
            }
          }
        });
      }
  }
  transferamount(type:any)
  {
    this.transferdata.transfer_to=this.model.username;
    this.transferdata.transfer_from=localStorage.getItem('currentUser');
    this.transferdata.type = type;
    this.transferdata.amt=(type==1)?this.model.share_amt:this.elearningmodel.share_amt;
    if(type==1)
    {
      $('.preloader loader-2').show();
    }else{
      $('.preloader loader-1').show();
    }
    
    
    this.CommonService.insertdata(this.inserttrasnfeprocessRestApiUrl,this.transferdata)
    .subscribe(package_det =>{
      if(type==1){
        $('.preloader loader-2').hide();
      }else{
        $('.preloader loader-1').hide();
      }       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.model.mname = '';
         this.model.share_amt = '';
        this.ngOnInit(); 
    });
  }
   
  userweb(website_name:any)
  {
    this.model.user_web_url=website_name;
    // this.model.template=template;
     this.CommonService.insertdata(this.userwebsiteurl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/dashboard']); 
    });
  }
  onGoToPage2(package_name:any,package_price:any,userid:any,pack_id:any,pack_id_user:any,website:any,template:any)
  {
    
    this.model.package_name = package_name;
    this.model.package_price = package_price;
    this.payment_data.userid = userid;//user_vs_package user id
    this.payment_data.pack_id =pack_id;//user_vs_pacakge package if
    this.payment_data.pack_id_user=pack_id_user;//user_vs_packeg mastr id
    this.model.website = website;
    this.checkIswebsite=(this.model.website!='')?true:false;
    this.model.template = template;
    this.model.p_id = pack_id_user;
    
    
    
  }
  
   paytoactivate()
  { 
    this.payment_data.website = this.model.website;
    this.details_array.push(this.payment_data);
   // $('.preloader').show();
    this.isPaid=true;
    //return false;
    this.showButton=true;
     this.CommonService.insertdata(this.packageActivateApiUrl,this.details_array)
    .subscribe(payment_status =>{ 
      if(payment_status.status=='success')
      {
        swal('','Package activated successfully','success');
        this.payment_data='';
        this.model='';
        this.isPaid=false;
         $('#exampleModal').modal('toggle');
          let user_id = localStorage.getItem('currentUserID');
          this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
              .subscribe(resultdata =>{   
                this.packagelist=resultdata.result; 
              });
              //$('.preloader').hide();
              
              this.showButton=false;
            }
      else if(payment_status.status=='user_error'){
        swal('','Not a valid user or invalid user data','error');        
        //this.payment_data='';
        //this.model='';
         //this.isPaid=true;
        $('.preloader').hide();
      }
      else if(payment_status.status=='fail'){
        swal('','user has less amount on his own','error');
        $('.preloader').hide();
       // this.payment_data=''; 
        //this.model='';
      }
      else{
        swal('','Error while on activate package','error');
        $('.preloader').hide();
       // this.payment_data=''; 
        //this.model='';
      }
     
    });
  }
  restrictNumbers(event: any)
  {
      const pattern = /[0-9\+\-\ ]/;
      const inputChar = String.fromCharCode(event.charCode);

      if (!pattern.test(inputChar)) {    
          // invalid character, prevent input
          event.preventDefault();
      }
  }
}
