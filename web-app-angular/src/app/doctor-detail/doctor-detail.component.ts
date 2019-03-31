import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-doctor-detail',
  templateUrl: './doctor-detail.component.html',
  styleUrls: ['./doctor-detail.component.less']
})
export class DoctorDetailComponent implements OnInit {

  apiUrl = 'http://192.168.1.134:8000/api/patient/1/doctors';
  doctor_id:any;
  doctor = {};


  constructor(private route:ActivatedRoute, private http: HttpClient, private router: Router) { }

  ngOnInit() {
    this.doctor_id = this.route.params['_value'].id;

    this.http.get(this.apiUrl).subscribe(r=>{
      for (let i = 0; i < r['all_doctors'].length; i++) {
        if (this.doctor_id == r['all_doctors'][i].id) {
          this.doctor = r['all_doctors'][i];
        }
      }
    });

  }

  sendInvitation(user_id){

    this.router.navigate(['/user-dashboard']);

    return this.http.post('http://192.168.1.134:8000/api/patient/'+ user_id +'/add/'+this.doctor_id, 'kokotko').subscribe();
  }

}
