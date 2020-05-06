import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PremiumtransactionComponent } from './premiumtransaction.component';

describe('PremiumtransactionComponent', () => {
  let component: PremiumtransactionComponent;
  let fixture: ComponentFixture<PremiumtransactionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PremiumtransactionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PremiumtransactionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
