import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managegroupchannel',
  templateUrl: './viewsubscribers.component.html',
  styleUrls: ['./managegroupchannel.component.css']
})
export class ViewsubscribersComponent implements OnInit {
  private sub: any;
  model:any={};  
  id:number;
   constructor(private loginService: LoginService,private route: ActivatedRoute,private CommonService: CommonService,private router: Router) { }
   subscriberslist:Array<Object>;
  ngOnInit() {
  	this.loginService.localStorageData();
     this.loginService.viewsActivate();
     
        this.sub = this.route.params.subscribe(params => {
        this.id = +params['id'];
        this.editchat(this.id);        
        });
  }
   editchat(id:any)
	  {
	      this.CommonService.editdata(AppSettings.FetchsubscribersbygroupRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.subscriberslist = resultdata.result;                
        });
	  }
  deletesubscriber(id:any)
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
          self.removesubscriber(idx);
         
        }        
      },function(dismiss) {
    });
  }
 removesubscriber(idx:any)
 {
   this.CommonService.deletedata(AppSettings.DeletesubscriberRestApiUrl,idx)
        .subscribe(resultdata =>{        
          if(resultdata!="")
          { 
            swal('Deleted!','Data has been deleted.','success');
            this.ngOnInit();           
          }
          });
          } 

}
