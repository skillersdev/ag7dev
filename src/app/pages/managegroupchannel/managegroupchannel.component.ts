import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managegroupchannel',
  templateUrl: './managegroupchannel.component.html',
  styleUrls: ['./managegroupchannel.component.css']
})
export class ManagegroupchannelComponent implements OnInit {

   constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
   chatgrouplist:Array<Object>;
  ngOnInit() {
  	this.loginService.localStorageData();
     this.loginService.viewsActivate();
      this.CommonService.getdata(AppSettings.getchatgroupslist)
        .subscribe(det =>{
              this.chatgrouplist=det;
            console.log(det);
             
        });
  }
   viewchat(id:any)
	  {
	     this.router.navigate(['/viewchat', id]);
	  }
	  viewsubscribers(id:any)
	  {
	     this.router.navigate(['/viewsubscribers', id]);
	  }
}
