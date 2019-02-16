import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';

@Component({
  selector: 'app-manageservice',
  templateUrl: './manageservice.component.html',
  styleUrls: ['./manageservice.component.css']
})
export class ManageserviceComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  navigateAddservice()
  {
    this.router.navigate(['/addservice']);
  }

}
