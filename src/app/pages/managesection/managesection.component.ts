import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managesection',
  templateUrl: './managesection.component.html',
  // styleUrls: ['./managesection.component.css']
})
export class ManagesectionComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
 model:any={};
 sectionList:Array<Object>;
  ngOnInit() {
  	this.model.user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionList=resultdata.result; 
    });
  	
    
  }
  navigateAddsection()
  {
  	this.router.navigate(['/addsection']);
  }
  managereorder()
  {
  	
  }
}
