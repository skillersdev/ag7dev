import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-websitesettings',
  templateUrl: './websitesettings.component.html',
  styleUrls: ['./websitesettings.component.css']
})
export class WebsitesettingsComponent implements OnInit {
  FetchuserRestApiUrl: string = AppSettings.Edituser; 
  UpdateSectionsRestApiUrl: string = AppSettings.UpdateDefaultsections; 
  model: any = {};
  constructor(private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.model.id = localStorage.getItem('currentUserID');
    this.edituser(this.model.id);
  }
  edituser(id:any)
  {
    
    this.CommonService.editdata(this.FetchuserRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model.defaultsections = resultdata.result.website_default_sections.split(',').map(name => ({name}));
          this.model.dummySections = resultdata.result.website_default_sections.split(',');
          this.model.defaultsections_val = resultdata.result.website_default_sections_val.split(',');
          console.log(this.model.defaultsections);
        });
  }
  editcategory(name,index){
    this.model.section_name = name;
    this.model.currentIndex = index;
    
    $('#ctemplateModal').modal('show');
  }
  updateSections(){
    this.model.dummySections[this.model.currentIndex] = this.model.section_name;
    this.model.defaultsections_val_string = this.model.dummySections.toString();
    this.CommonService.updatedata(this.UpdateSectionsRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.ngOnInit();
        $('#ctemplateModal').modal('hide');
        
    });
    console.log(this.model.dummySections)
  }
  navigateReorderpage(){
    this.router.navigate(['/websitesettingsreorder']);
  }
}
