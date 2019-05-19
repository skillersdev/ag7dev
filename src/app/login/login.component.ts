import { Component, Injectable, OnInit} from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Router } from '@angular/router';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
declare let swal: any;
declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent implements OnInit {

  model: any = {};
  data:any={};
  entered:any;
  users :any= []; //storing the data from the API
  userRestApiUrl: string = AppSettings.Userlogin; //API common URL

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) {

    document.body.className="login-page";

   }

  ngOnInit() {
     this.entered = 0;

     let translate_url="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    this.loadScript(translate_url);
     
  }

  public loadScript(url) {
    console.log('preparing to load...')
    let node = document.createElement('script');
    node.src = url;
    node.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(node);
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
    }
    else 
    {
      if(usernme!=null && userpass!=null){
          this.CommonService.checkexistdata(this.userRestApiUrl,this.model).subscribe(data=>{
              if(data.exist==1)
              {
                let user_det = data.result[0];
                console.log(user_det);
                localStorage.setItem('currentUser', user_det.username);
                localStorage.setItem('currentUserID', user_det.id);
                localStorage.setItem('currentUsergroup',user_det.user_type);
                localStorage.setItem('user_fname',user_det.fname);
                localStorage.setItem('email',user_det.email);
                localStorage.setItem('address',user_det.address);
                localStorage.setItem('tamount',user_det.tamount);
                if(user_det.user_type==1)
                {
                  this.router.navigate(['./admindashboard']);
                  // swal('', data.message, 'success');
                }
                else{
                  this.router.navigate(['./dashboard']);
                  // swal('', data.message, 'success');
                }
              }
              /*No Single Package is not yet activated*/
             
              else
              {
                swal('Oops...', data.message, 'error');
                this.router.navigate(['/']);
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
    }


}
