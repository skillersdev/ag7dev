import { Component, Injectable, OnInit} from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Router } from '@angular/router';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare let swal: any;
declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-malllogin',
  templateUrl: './malllogin.component.html',
  styleUrls: ['./malllogin.component.css'],
})
export class MallloginComponent implements OnInit {

  model: any = {};
  data:any={};
  entered:any;
  users :any= []; //storing the data from the API
  userRestApiUrl: string = AppSettings.Malllogin; //API common URL

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) {

    document.body.className="login-page";

   }

  ngOnInit() {
     this.entered = 0;
    this.model.type=1;
    this.loginService.viewsActivate();
    //  let translate_url="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    //this.loadScript(translate_url);
     
  }
 

   enterlogin()
  {
    if(this.entered==0)
    {
      this.checklogin();
      this.entered=1;
    }
    if(this.entered==1)
    {
      //this.login();
      this.entered=0;
    }
  }  

  checklogin(){
    //alert(JSON.stringify(this.model));

    let usernme = null;
    let userpass = null;
    usernme = this.model.user_name;
    userpass = this.model.user_password;
   // alert(usernme);
    if((usernme==undefined || usernme==null)&&(userpass==undefined || userpass==null))
    {
      swal('Oops...', 'Enter Valid username or password', 'error');
      
      if(this.entered==0)
      {
        this.entered=1;
      }
      // window.location.reload();
    }
    else 
    {
      if(usernme!=null && userpass!=null){
          this.CommonService.checkexistdata(this.userRestApiUrl,this.model).subscribe(data=>{
              if(data.exist==1)
              {
                let user_det = data.result[0];

                localStorage.setItem('mallcurrentUser', user_det.username);
                
                localStorage.setItem('malltypeid', this.model.type);
                localStorage.setItem('mallLogin', "true");
                localStorage.setItem('usergroup',user_det.usergroup);

                //console.log("user_det-->",user_det);
                
                  if(this.model.type==1)
                  {
                    this.router.navigate(['./mall/managemall']);
                    localStorage.setItem('mallid', user_det.id);
                    // swal('', data.message, 'success');
                  }
                  else if(this.model.type==2)
                  {
                    localStorage.setItem('mallid', user_det.mall_id);
                    localStorage.setItem('floorid', user_det.id);
                    this.router.navigate(['./mall/managefloor']);
                    
                  } else if(this.model.type==3)
                  {
                    localStorage.setItem('mallid', user_det.mall_id);
                    localStorage.setItem('floorid', user_det.floor_id);
                    localStorage.setItem('shopid', user_det.id);
                    this.router.navigate(['./mall/manageshop']);
                  }
                  else{
                    localStorage.setItem('mallid', user_det.mall_id);
                    localStorage.setItem('floorid', user_det.floor_id);
                    localStorage.setItem('shopid', user_det.shop_id);
                    localStorage.setItem('productid', user_det.id);
                    this.router.navigate(['./mall/manageproduct']);
                    // swal('', data.message, 'success');
                  }
              }
              /*No Single Package is not yet activated*/
             
              else
              {
                swal('Oops...', data.message, 'error');
                // this.router.navigate(['/']);
                // window.location.reload();
              }
          });
        
      }
    }
	
    // if(usernme!=undefined && userpass!=null){

    // var headers = new Headers();
    // headers.append('Authtoken','123456');

    
    //     this.loginService.checkUsers(this.userRestApiUrl,this.model)
    // .subscribe(data =>{
    //               console.log(JSON.stringify(data));
                
    //               if (data =="NULL") //!=
    //              {
    //                 this.users = data;
                    
    //                 if( this.users !=""){
                      
    //                   if(this.users.user_type =='1')
    //                   {
    //                     localStorage.setItem('currentUser', this.users.username);
    //                     localStorage.setItem('currentUserID', this.users.id);
    //                     localStorage.setItem('currentUsername', this.users.username);
    //                     localStorage.setItem('currentUsergroup', this.users.user_type);
    //                     this.router.navigate(['./admindashboard']);
    //                   }
    //                   else if(this.users.user_type =='2')
    //                   {
    //                     localStorage.setItem('currentUser', this.users.username);
    //                     localStorage.setItem('currentUserID', this.users.id);
    //                     localStorage.setItem('currentUsername', this.users.username);
    //                     localStorage.setItem('currentUsergroup', this.users.user_type);
    //                     this.router.navigate(['./dashboard']);
    //                   }

    //                 }else{
    //                    this.router.navigate(['/']);
    //                 }
                    
    //               }
    //             else
    //             {
                   
    //                localStorage.removeItem('currentUser');
    //                localStorage.removeItem('currentUserID');
    //                localStorage.removeItem('currentUsername');
    //                localStorage.removeItem('currentUsergroup');
               
    //                alert('Enter valid username and password');
                   
    //             }
    //       });
    // }
                
  }


  logout() {
        // remove user from local storage to log user out
      	// swal('', 'You have Successfully Logged Out', 'success');        
        localStorage.removeItem('currentUser');
        localStorage.clear();
    }


}
