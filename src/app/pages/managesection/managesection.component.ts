import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managesection',
  templateUrl: './managesection.component.html',
  // styleUrls: ['./managesection.component.css']
})
export class ManagesectionComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
  }
  navigateAddsection()
  {
  	this.router.navigate(['/addsection']);
  }
  managereorder()
  {
  	
  }
}
