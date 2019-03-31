import { Component, OnInit, ChangeDetectionStrategy, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.less']
})

@Injectable()
export class UserDashboardComponent implements OnInit {

  doctorsUrl = 'http://192.168.1.134:8000/api/patient/1/doctors';
  public doctors = [];
  allDoctors = [];
  seeDoctors = false;
  sortDoctor = [];

  constructor(private http: HttpClient, private router: Router, private route:ActivatedRoute) { }

  ngOnInit() {

    this.http.get(this.doctorsUrl).subscribe(r=>{
      this.doctors = r['current_doctors'];
    })

    this.http.get(this.doctorsUrl).subscribe(r=>{
      this.allDoctors = r['all_doctors'];
    })

  }

  onTextChange(name){
    this.sortDoctor = [];
    for (let i = 0; i < this.allDoctors.length; i++) {
      if (this.allDoctors[i].name.includes(name)) {
        this.sortDoctor.push(this.allDoctors[i])
        this.seeDoctors = true;
      }
    }
  }

}
