import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MarketmanagersComponent } from './marketmanagers.component';

describe('MarketmanagersComponent', () => {
  let component: MarketmanagersComponent;
  let fixture: ComponentFixture<MarketmanagersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MarketmanagersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MarketmanagersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
