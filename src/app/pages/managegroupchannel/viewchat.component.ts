import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managegroupchannel',
  templateUrl: './viewchat.component.html',
  styleUrls: ['./managegroupchannel.component.css']
})
export class ViewchatComponent implements OnInit {
  private sub: any;
  model:any={};  
  id:number;
   constructor(private loginService: LoginService,private route: ActivatedRoute,private CommonService: CommonService,private router: Router) { }
   chatgrouplist:Array<Object>;
  ngOnInit() {
  	this.loginService.localStorageData();
     this.loginService.viewsActivate();
     
        this.sub = this.route.params.subscribe(params => {
        this.id = +params['id'];
        this.editchat(this.id);        
        });
  }
   editchat(id:any)
	  {
	      this.CommonService.editdata(AppSettings.FetchchatbygroupRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.chatgrouplist = resultdata.result; 
               
        });
	  }
}
