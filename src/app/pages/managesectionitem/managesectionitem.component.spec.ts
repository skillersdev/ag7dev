import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagesectionitemComponent } from './managesectionitem.component';

describe('ManagesectionitemComponent', () => {
  let component: ManagesectionitemComponent;
  let fixture: ComponentFixture<ManagesectionitemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagesectionitemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagesectionitemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
