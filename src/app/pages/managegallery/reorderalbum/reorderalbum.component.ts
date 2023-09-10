import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
import {CdkDragDrop, moveItemInArray} from '@angular/cdk/drag-drop';

@Component({
  selector: 'app-reorderalbum',
  templateUrl: './reorderalbum.component.html',
  styleUrls: ['./reorderalbum.component.css']
})
export class ReorderalbumComponent implements OnInit {

 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
  model:any={};
  movies:Array<Object>;
  sectionItemList:Array<Object>;
  select:any;
   ngOnInit() {
     
     this.model.userId = localStorage.getItem('currentUserID');
     this.model.usergroup=localStorage.getItem('currentUsergroup');
     
     this.CommonService.insertdata(AppSettings.GetalbumListbyUser,this.model)
     .subscribe(resultdata =>{   
       this.sectionItemList=resultdata.result[0]; 
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
     moveItemInArray(this.sectionItemList, event.previousIndex, event.currentIndex);
     console.log(this.sectionItemList);
   }
 
   navigatesection()
   {
     this.router.navigate(['/managesectionitem']);	
   }
   savereorder()
   {
     this.model.orderlist = this.sectionItemList;
     this.CommonService.insertdata(AppSettings.albumitemreorderinginsert,this.model)
     .subscribe(resultdata =>{   
       this.sectionItemList=resultdata.result;
       swal('Success!','Album items has been reordered successfully.','success'); 
       this.ngOnInit();
     });
   }
  

}
