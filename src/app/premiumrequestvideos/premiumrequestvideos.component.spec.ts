import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PremiumrequestvideosComponent } from './premiumrequestvideos.component';

describe('PremiumrequestvideosComponent', () => {
  let component: PremiumrequestvideosComponent;
  let fixture: ComponentFixture<PremiumrequestvideosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PremiumrequestvideosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PremiumrequestvideosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
