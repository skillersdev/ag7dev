import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { AppComponent } from '../../../app.component';
import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-editsection',
  templateUrl: './editsection.component.html',
  // styleUrls: ['./editsection.component.css']
})
export class EditsectionComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,
    private route: ActivatedRoute,private router: Router,private http:Http) { }
  websitelist:Array<Object>;
  private sub: any;
  model: any = {};
  alldata:any={};
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  id:any;

  ngOnInit() {
  	this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');
  
     this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
    .subscribe(package_det =>{       
      if(package_det.result!=""){ this.websitelist=package_det.result;}
    }); 
  	this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editsection(this.id);        
    });
  }
  editsection(id:any)
  {
    this.CommonService.editdata(AppSettings.FetchSectionData,id)
    .subscribe(resultdata =>{   
      this.model = resultdata.result; 
      this.model.Issection_show = (this.model.Issection_show==1)?true:false;      
    });
  }
  update_section()
  {
  	console.log(this.model.Issection_show);
  	this.model.Issection_show = (this.model.Issection_show==false)?0:1;
  	this.CommonService.updatedata(AppSettings.updateSectiondata,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/managesection']);
        
    });
  }
  back()
	{
	  	 this.router.navigate(['/managesection']);
	}

}
