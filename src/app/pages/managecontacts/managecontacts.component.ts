import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
@Component({
  selector: 'app-managecontacts',
  templateUrl: './managecontacts.component.html',
  styleUrls: ['./managecontacts.component.css']
})
export class ManagecontactsComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  navigateAddcontact()
  {
    this.router.navigate(['/addcontact']);
  }
}
