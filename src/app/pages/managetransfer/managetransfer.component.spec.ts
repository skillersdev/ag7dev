import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagetransferComponent } from './managetransfer.component';

describe('ManagetransferComponent', () => {
  let component: ManagetransferComponent;
  let fixture: ComponentFixture<ManagetransferComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagetransferComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagetransferComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
