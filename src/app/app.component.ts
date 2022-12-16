import { Component ,ViewEncapsulation } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'adminpanel';
  constructor(public translate:TranslateService)
  {
    translate.addLangs(['English', 'Persian','Turkish','Korean','German']);
      translate.setDefaultLang('English');
  }
  ngOnInit() {

  //   let translate_url="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
  //  this.loadScript(translate_url);

 }

 public loadScript(url) {
  console.log('preparing to load...')
  // let node = document.createElement('script');
  // node.src = url;
  // node.type = 'text/javascript';
  // document.getElementsByTagName('head')[0].appendChild(node);
}
switchLang(lang: string) {    
  this.translate.use(lang);
  localStorage.setItem('languageType',lang);
}


}
