import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService} from '../services/common.service';
import { TranslateService } from '@ngx-translate/core';
declare let swal: any;
@Component({
  selector: 'app-landingpage',
  templateUrl: './landingpage.component.html',
  styleUrls: ['./landingpage.component.css']
})
export class LandingpageComponent implements OnInit {
CheckwebsiteExistsRestApiUrl:string = AppSettings.checkwebsitedetail; 
websiteurl:string=AppSettings.USER_TEMPLATE;
model: any = {};
  constructor(
  	private loginService: LoginService,private CommonService: CommonService,
  	private router: Router,private http:Http,private translate:TranslateService) {

      document.body.className=" ";
      translate.addLangs(['English', 'Persian']);
      translate.setDefaultLang('English');

     }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    if(localStorage.getItem('languageType'))
    {
      var stringLang = localStorage.getItem('languageType');
      this.switchLang(stringLang);
    }

  }
  switchLang(lang: string) {    
    this.translate.use(lang);
    localStorage.setItem('languageType',lang);
  }
  // public loadScript(url) {
  //   console.log('preparing to load...')
  //   let node = document.createElement('script');
  //   node.src = url;
  //   node.type = 'text/javascript';
  //   document.getElementsByTagName('head')[0].appendChild(node);
  // }


   checkwebsite()
  {
    // console.log(this.model.website); 
    if((this.model.website!=undefined)&&(this.model.website!=''))
    {
      this.CommonService.checkexistdata(this.CheckwebsiteExistsRestApiUrl,this.model)
    .subscribe(package_det =>{
     
      if(package_det.exist==1)
      {
        window.open(this.websiteurl+"/"+this.model.website, '_blank');
        // swal('',package_det.message,'error')
        this.model.website='';
      } 
      else
      {
        localStorage.setItem('website_name', this.model.website);
        this.router.navigate(['./signup']);
      } 
    });
    }
    else{
      swal('','Enter your website name','error')
        this.model.website='';
    }
  }

  navigatetologin()
  {
    this.router.navigate(['./login']);
  }

  navigatetosignup(){
    this.router.navigate(['./signup']);
  }

}
