import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
import {CdkDragDrop, moveItemInArray} from '@angular/cdk/drag-drop';

declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-reordersection',
  templateUrl: './reordersection.component.html',
  styleUrls: ['./reordersection.component.css']
})
export class ReordersectionComponent implements OnInit {
	 
   constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
 model:any={};
 movies:Array<Object>;
 sectionList:Array<Object>;
 select:any;
  ngOnInit() {
  	
  	this.model.user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    
    this.CommonService.insertdata(AppSettings.GetsectionsListbyshow,this.model)
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
  	this.router.navigate(['/reordersection']);	
  }
  editsection(id:any)
  {
  	this.router.navigate(['/editsection', id]);
  }
  drop(event: CdkDragDrop<string[]>) {  	
    moveItemInArray(this.sectionList, event.previousIndex, event.currentIndex);
    console.log(this.sectionList);
  }

  navigatesection()
  {
  	this.router.navigate(['/managesection']);	
  }
  savereorder()
  {
  	this.model.orderlist = this.sectionList;
  	this.CommonService.insertdata(AppSettings.sectionreorderinginsert,this.model)
    .subscribe(resultdata =>{   
      this.sectionList=resultdata.result;
      swal('Success!','Section has been reordered successfully.','success'); 
      this.ngOnInit();
    });
  }
 

}
