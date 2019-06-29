import { Component, OnInit } from '@angular/core';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
//import { Routes,Router,RouterModule}  from '@angular/router';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';

@Component({
  selector: 'app-chatgroup',
  templateUrl: './chatgroup.component.html',
  styleUrls: ['./chatgroup.component.css']
})
export class ChatgroupComponent implements OnInit {
  Chatcode:any;
  chatgroup:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,
  	private router: Router,private route: ActivatedRoute,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
  	this.loginService.localStorageData();
    this.loginService.viewsActivate();
     this.route.params.subscribe(params => {
        this.Chatcode = params['code']; 
     });
        console.log(localStorage.getItem('currentUser'));
        if(localStorage.getItem('currentUser')==null)
		    {
		       localStorage.setItem('chatcode',this.Chatcode);
		       this.router.navigate(['./']);
		       return false;
		    }
		 else
		 {
		 	/*Check user is under group*/
		 	this.chatgroup.groupcode = this.Chatcode;
		 	this.chatgroup.user_id = localStorage.getItem('currentUserID');
		 	this.CommonService.insertdata(AppSettings.checkuserIsgroupRestApiUrl,this.chatgroup)
		        .subscribe(group_det =>{       
		          if(group_det.exist==0)
		          { 
		          	let self = this;
				      swal({
				        title: 'Are you sure?',
				         buttons: {
				            cancel: true,
				            confirm: true,
				          },
				        text: "want to join this group?",
				      }).then(function (result) 
				      {
				        if(result)
				        {
				        	self.chatgroup.group_id = group_det.group_id;
				 		    self.chatgroup.group_name =group_det.group_name;
				           self.adduserbygroup();
				          swal(
				            'Joined!',
				            'Successfully joined into this group',
				            'success'
				          )
				          this.router.navigate(['/chat']);
				        }
				      },function(dismiss) {
				    });
		          }
		      });
		 	




		 	 // this.CommonService.insertdata(AppSettings.checkuserIsgroupRestApiUrl,this.chatgroup)
		   //      .subscribe(group_det =>{       
		   //        if(group_det.exist==0)
		   //        { 
		   //        	console.log(group_det);
		   //        	let self = this;
		   //        	 swal({
				 //        title: 'Are you sure?',
				 //         buttons: { cancel: true,
				 //            confirm: true,
				 //          },
				 //        text: "want to join this group",
				 //      }).then(function (result) {
				 //        if(result)
				 //        {
				 //       	 this.chatgroup.group_id = group_det.group_id;
				 //       	 this.chatgroup.group_name =group_det.group_name;
				 //       	 this.adduserbygroup();	
				 //        }        
				 //      },function(dismiss) {
				 //    });
		   //        }
		   //        else{
		   //        	this.router.navigate(['/chat']);
		   //        }
		   //      });
		 }   
        // let chatcodeexists = localStorage.getItem('chatcode'); 
        // if(chatcodeexists!='')
        // {
        // 	localStorage.removeItem('chatcode');
        // }
       
  }
  adduserbygroup()
  {
  		 this.CommonService.insertdata(AppSettings.addusergroupApiUrl,this.chatgroup)
			 .subscribe(test =>{  

			 });
  }

}
