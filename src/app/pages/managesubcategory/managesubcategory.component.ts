import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

@Component({
  selector: 'app-managesubcategory',
  templateUrl: './managesubcategory.component.html',
  styleUrls: ['./managesubcategory.component.css']
})
export class ManagesubcategoryComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  navigateAddsubcategory()
  {
    this.router.navigate(['/addsubcategory']);
  }
}
