import { Component, Injectable, OnInit} from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Router } from '@angular/router';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
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

  constructor(private loginService: LoginService,private router: Router,private http:Http) {

    document.body.className="login-page";

   }

  ngOnInit() {
     this.entered = 0;
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
    if(usernme==undefined || usernme==null)
    {
     // swal('Oops...', 'Enter User Name', 'error');
      alert('Enter User Name');
      if(this.entered==0)
      {
        this.entered=1;
      }
    }
    else if(userpass==null)
    {
      //swal('Oops...', 'Enter Password', 'error');
      alert('Enter Password');
      if(this.entered==0)
      {
        this.entered=1;
      }
    }
	
    if(usernme!=undefined && userpass!=null){

    var headers = new Headers();
    headers.append('Authtoken','123456');

    
        this.loginService.checkUsers(this.userRestApiUrl,this.model)
    .subscribe(data =>{
                  //console.log(JSON.stringify(data));
                 if (data !="NULL")
                 {
                    this.users = data;
                    
                    if( this.users !=""){
                      // store user details in local storage to keep user logged in between page refreshes
                      localStorage.setItem('currentUser', this.users.name);
                      localStorage.setItem('currentUserID', this.users.id);
                      localStorage.setItem('currentUsername', this.users.name);
                      localStorage.setItem('currentUsergroup', this.users.user_type_id);
                      localStorage.setItem('currentUserStatus', this.users.is_deleted);
                      this.router.navigate(['./dashboard']);
                    }else{
                       this.router.navigate(['/']);
                    }
                    
                  }
                else
                {
                   
                   localStorage.removeItem('currentUser');
                   localStorage.removeItem('currentUserID');
                   localStorage.removeItem('currentUsername');
                   localStorage.removeItem('currentUsergroup');
                   localStorage.removeItem('currentUserStatus');
                   //alert('Enter valid username and password');
                   alert('Enter valid username and password');
                   
                }
          });
    }
                
  }


  logout() {
        // remove user from local storage to log user out
      	// swal('', 'You have Successfully Logged Out', 'success');        
        localStorage.removeItem('currentUser');
    }


}
