import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';

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
 allmodel:any={};
 sectionList:Array<Object>;
 buttonlist:Array<Object>;
 menulist:Array<Object>;
 defaultsectionlist:Array<Object>;
 qtd:any={};
 checked_hide:any={};
 checked_show:any={};
  ngOnInit() {
  	this.model.user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionList=resultdata.result; 
      this.buttonlist=resultdata.checkedresult; 
      this.menulist=resultdata.menucheckedresult; 
      this.loginService.viewCommontdataTable('section_table','section_table');
    });

    this.CommonService.insertdata(AppSettings.GetDefaultsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.defaultsectionlist=resultdata.result; 
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

            this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
            .subscribe(resultdata =>{   
              this.sectionList=resultdata.result; 
              this.buttonlist=resultdata.checkedresult; 
              this.menulist=resultdata.menucheckedresult; 
            });
            // this.ngOnInit();
           
          } 

      });
 }
 updatesectionData(event:any,id:any)
 {   
   $('.preloader').show();   
 	this.model.Isshow = (event.checked==true)?1:0;
   this.model.secId = id;
   this.model.default=1;
   console.log(this.model)
 	 this.CommonService.insertdata(AppSettings.updateSectionbytoggle,this.model)
    .subscribe(resultdata =>{   
     // this.ngOnInit();
      $('.preloader').hide();
    });  	
 }

 updateMenusectionData(event:any,id:any)
 {   
   $('.preloader').show();   
 	this.model.Isshowmenu = (event.checked==true)?1:0;
   this.model.secId = id;
   this.model.default=1;
 	 this.CommonService.insertdata(AppSettings.updateSectionbytoggle,this.model)
    .subscribe(resultdata =>{   
     // this.ngOnInit();
      $('.preloader').hide();
    });  	
 }

 updatesectionDefault(eventValue:any,idx:any)
 {
   this.allmodel.section = eventValue;
   this.allmodel.secId = idx;
   this.allmodel.default=1;
   this.allmodel.Isshow = (eventValue==true)?1:0;
    this.CommonService.insertdata(AppSettings.updateSectionbytoggle,this.allmodel)
    .subscribe(resultdata =>{   
      this.ngOnInit();
      $('.preloader').hide();
    }); 
 }
 

}
