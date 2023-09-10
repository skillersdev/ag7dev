import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WebsitesettingsreorderComponent } from './websitesettingsreorder.component';

describe('WebsitesettingsreorderComponent', () => {
  let component: WebsitesettingsreorderComponent;
  let fixture: ComponentFixture<WebsitesettingsreorderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WebsitesettingsreorderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WebsitesettingsreorderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
