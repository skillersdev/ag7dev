import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-marketmanagers',
  templateUrl: './marketmanagers.component.html',
  styleUrls: ['./marketmanagers.component.css']
})
export class MarketmanagersComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }
  redirectWebsite()
  {
    window.open("http://roodabatoz.com/newsite/marketerpage/","_blank");
  }

}
