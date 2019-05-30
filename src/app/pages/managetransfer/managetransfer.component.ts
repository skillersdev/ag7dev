import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';

import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';
@Component({
  selector: 'app-managetransfer',
  templateUrl: './managetransfer.component.html',
  styleUrls: ['./managetransfer.component.css']
})
export class ManagetransferComponent implements OnInit {
 gettransferlist:string = AppSettings.gettransferlistDetail;
 model:any={}; 
 transferlist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
     this.model.currentUsername=localStorage.getItem('currentUser');
      this.CommonService.insertdata(this.gettransferlist,this.model)
    .subscribe(package_det =>{ 
        this.transferlist = package_det;
        
    });
     
  }

}
