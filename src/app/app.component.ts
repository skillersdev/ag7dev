import { Component ,ViewEncapsulation } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'adminpanel';

  ngOnInit() {

    let translate_url="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
   this.loadScript(translate_url);

 }

 public loadScript(url) {
  console.log('preparing to load...')
  let node = document.createElement('script');
  node.src = url;
  node.type = 'text/javascript';
  document.getElementsByTagName('head')[0].appendChild(node);
}


}
