import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
import {CdkDragDrop, moveItemInArray} from '@angular/cdk/drag-drop';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-websitesettingsreorder',
  templateUrl: './websitesettingsreorder.component.html',
  styleUrls: ['./websitesettingsreorder.component.css']
})
export class WebsitesettingsreorderComponent implements OnInit {

  FetchuserRestApiUrl: string = AppSettings.Edituser; 
  UpdateSectionsRestApiUrl: string = AppSettings.UpdateDefaultsections; 
  model: any = {};
  reorderItems:Array<Object>=[];
  constructor(private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    
    this.model.id = localStorage.getItem('currentUserID');
    this.reorderItems=[];
    this.edituser(this.model.id);
  }
  edituser(id:any)
  {
   
    this.CommonService.editdata(this.FetchuserRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model.defaultsections = resultdata.result.website_default_sections.split(',').map(name => ({name}));

          this.model.dummySections = resultdata.result.website_default_sections.split(',');
          this.model.defaultsections_val = resultdata.result.website_default_sections_val.split(',');
          
          this.model.defaultsections= this.model.defaultsections.map((ob, i) => ({ ...ob,
            "order_val": this.model.defaultsections_val[i]
          }));
          console.log(this.model.defaultsections)
          this.model.defaultsections_val.find((value,index)=> {
            if(value=='P'){ 
               this.reorderItems.push({'name':this.model.defaultsections[0]['name'],'order_val':value})
            }
            else if(value=='C'){
               this.reorderItems.push({'name':this.model.defaultsections[2]['name'],'order_val':value})
            }
            else if(value=='A'){
               this.reorderItems.push({'name':this.model.defaultsections[1]['name'],'order_val':value})
            }
            
          });
          this.model.defaultsections = this.reorderItems;
        });
  }
  editcategory(name,index){
    this.model.section_name = name;
    this.model.currentIndex = index;
    
    $('#ctemplateModal').modal('show');
  }
  savereorder(){
    this.model.tempwebsite_default_sections_val =this.model.defaultsections;
    this.model.tempwebsite_default_sections_val.forEach(object => {delete object['name']});
    this.model.tempwebsite_default_sections_val = this.model.tempwebsite_default_sections_val.map(a => a.order_val);
    
    this.CommonService.updatedata(this.UpdateSectionsRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.ngOnInit();
       
    });
   
  }
  navigatesection(){
    this.router.navigate(['/websitesettings']);
  }
  drop(event: CdkDragDrop<string[]>) {  	
    moveItemInArray(this.model.defaultsections, event.previousIndex, event.currentIndex);
    console.log(this.model.defaultsections);
  }
}
