import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FreeTerminComponent } from './free-termin.component';

describe('FreeTerminComponent', () => {
  let component: FreeTerminComponent;
  let fixture: ComponentFixture<FreeTerminComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FreeTerminComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FreeTerminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
