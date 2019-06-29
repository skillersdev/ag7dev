import { Component, OnInit } from '@angular/core';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
//import { Routes,Router,RouterModule}  from '@angular/router';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';

@Component({
  selector: 'app-chatgroup',
  templateUrl: './chatgroup.component.html',
  styleUrls: ['./chatgroup.component.css']
})
export class ChatgroupComponent implements OnInit {
  Chatcode:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,
  	private router: Router,private route: ActivatedRoute,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
  	this.loginService.localStorageData();
    this.loginService.viewsActivate();
     this.route.params.subscribe(params => {
        this.Chatcode = params['code']; 
        if(localStorage.getItem('currentUser')==null)
		    {
		       localStorage.setItem('chatcode',this.Chatcode);
		       this.router.navigate(['./']);
		       return false;
		    }
        let chatcodeexists = localStorage.getItem('chatcode'); 
        if(chatcodeexists!='')
        {
        	localStorage.removeItem('chatcode');
        }
        });
  }

}
