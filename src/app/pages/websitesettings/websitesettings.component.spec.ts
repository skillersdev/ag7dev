import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WebsitesettingsComponent } from './websitesettings.component';

describe('WebsitesettingsComponent', () => {
  let component: WebsitesettingsComponent;
  let fixture: ComponentFixture<WebsitesettingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WebsitesettingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WebsitesettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
