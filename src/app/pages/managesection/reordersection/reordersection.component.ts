import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
import {CdkDragDrop, moveItemInArray} from '@angular/cdk/drag-drop';

declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-reordersection',
  templateUrl: './reordersection.component.html',
  styleUrls: ['./reordersection.component.css']
})
export class ReordersectionComponent implements OnInit {
	 movies = [
    'Episode I - The Phantom Menace',
    'Episode II - Attack of the Clones',
    'Episode III - Revenge of the Sith',
    'Episode IV - A New Hope',
    'Episode V - The Empire Strikes Back',
    'Episode VI - Return of the Jedi',
    'Episode VII - The Force Awakens',
    'Episode VIII - The Last Jedi',
    'Episode IX – The Rise of Skywalker'
  ];
   constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
 model:any={};
 sectionList:Array<Object>;
  ngOnInit() {
  	
  	this.model.user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    
    this.CommonService.insertdata(AppSettings.GetsectionsListbyshow,this.model)
    .subscribe(resultdata =>{   
      this.sectionList=resultdata.result; 
    });
  	
   
  }
  navigateAddsection()
  {
  	this.router.navigate(['/addsection']);
  }
  managereorder()
  {
  	this.router.navigate(['/reordersection']);	
  }
  editsection(id:any)
  {
  	this.router.navigate(['/editsection', id]);
  }
  drop(event: CdkDragDrop<string[]>) {  	
    this.model.arraylist= moveItemInArray(this.movies, event.previousIndex, event.currentIndex);
    console.log(this.model.arraylist);
  }

  navigatesection()
  {
  	this.router.navigate(['/managesection']);	
  }
 

}
