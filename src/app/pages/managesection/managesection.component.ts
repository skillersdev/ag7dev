import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

declare var jquery:any;
declare var $ :any;

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
  	this.router.navigate(['/reordersection']);	
  }
  editsection(id:any)
  {
  	this.router.navigate(['/editsection', id]);
  }

  deletesection(id:any)
  {
    let idx = id;
    let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) {
        if(result)
        {
          self.removesection(idx);
         
        }        
      },function(dismiss) {
    });
  }
 removesection(idx:any)
 {
   this.CommonService.deletedata(AppSettings.Deletesection,idx)
        .subscribe(resultdata =>{
          if(resultdata!="")
          { 
            // this.advertisementlist=[];
            swal('Deleted!','Data has been deleted.','success');
            this.ngOnInit();
           
          } 

      });
 }
 updatesectionData(event:any,id:any)
 {
 	$('.preloader').show();
 	this.model.Isshow = (event==true)?1:0;
 	this.model.sectionId = id;
 	 this.CommonService.insertdata(AppSettings.updateSectionbytoggle,this.model)
    .subscribe(resultdata =>{   
      this.ngOnInit();
      $('.preloader').hide();
    });
  	
 }


}
