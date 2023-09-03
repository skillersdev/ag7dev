import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReorderitemComponent } from './reorderitem.component';

describe('ReorderitemComponent', () => {
  let component: ReorderitemComponent;
  let fixture: ComponentFixture<ReorderitemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReorderitemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReorderitemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
