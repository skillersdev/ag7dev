import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from  '@angular/common/http';

import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { TopnavComponent } from './topnav/topnav.component';
import { SidemenuComponent } from './sidemenu/sidemenu.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { LoginComponent } from './login/login.component';
import { LoginService } from './services/login.service';
import { ManageuserComponent } from './pages/manageuser/manageuser.component';
import { SignupComponent } from './signup/signup.component';
import { ManagepackagesComponent } from './pages/managepackages/managepackages.component';
import { ManagepaymentsComponent } from './pages/managepayments/managepayments.component';
import { ProfileComponent } from './profile/profile.component';
import {AdduserComponent} from './pages/manageuser/adduser.component';



@NgModule({
  declarations: [
    AppComponent,
    TopnavComponent,
    SidemenuComponent,
    DashboardComponent,
    LoginComponent,
    ManageuserComponent,
    SignupComponent,
    ManagepackagesComponent,
    ManagepaymentsComponent,
    ProfileComponent,
    AdduserComponent,
  
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    HttpModule
  ],
  providers: [LoginService],
  bootstrap: [AppComponent]
})
export class AppModule { }
