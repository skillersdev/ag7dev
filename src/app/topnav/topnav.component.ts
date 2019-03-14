import { Component, OnInit } from '@angular/core';
import { CommonService } from '../services/common.service';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppSettings } from '../appSettings';

declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-topnav',
  templateUrl: './topnav.component.html',
  styleUrls: ['./topnav.component.css']
})
export class TopnavComponent implements OnInit {
  checkpackageisactivated:string = AppSettings.packageisactivated;
  constructor(private CommonService: CommonService,private router: Router) {

  
   }

  ngOnInit() {

     let id=localStorage.getItem('currentUserID');
     let user_type=localStorage.getItem('currentUsergroup');
     if(user_type!='1')
     {
      this.CommonService.editdata(this.checkpackageisactivated,id).subscribe(data=>{
         if(data.exist==2)
          {
           
           this.router.navigate(['./packageinfo']); 
          }
      });
    }

  }

   public loadScript(url) {
    console.log('preparing to load...')
    let node = document.createElement('script');
    node.src = url;
    node.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(node);
 }
  

}
