import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PremiumpackageComponent } from './premiumpackage.component';

describe('PremiumpackageComponent', () => {
  let component: PremiumpackageComponent;
  let fixture: ComponentFixture<PremiumpackageComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PremiumpackageComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PremiumpackageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
