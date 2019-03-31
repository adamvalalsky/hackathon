import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-my-doctor',
  templateUrl: './my-doctor.component.html',
  styleUrls: ['./my-doctor.component.less']
})
export class MyDoctorComponent implements OnInit {

  date = new Date();
  doc_id:any;
  doctor = {};
  calendar = [];
  no_days:any;
  month = this.date.getMonth()+1;
  day:any;
  month_name:any;

  constructor(private route: ActivatedRoute, private http: HttpClient, private router: Router, private change: ChangeDetectorRef) { }

  ngOnInit() {
    this.doc_id = this.route.params['_value'].id;

    this.http.get('http://192.168.1.134:8000/api/patient/1/doctor/'+ this.doc_id +'/current?month=0'+this.month).subscribe(r=>{
      this.doctor = r;
      this.calendar = r['calendar'];
      this.month = r['month'];
      this.month_name = r['text'];
      this.addNoDays(this.calendar[0].text);
    })

  }

  navigateToTermin(color, day){
    if (color == 'green') {
      this.router.navigate(['/free-termins/'+this.doc_id+'/'+this.month+'/'+day])
    }
  }

  switchMonth(value){
    this.calendar = [];
    this.no_days = null;
    if (value == 'next') {
      this.month ++;
      this.http.get('http://192.168.1.134:8000/api/patient/1/doctor/'+ this.doc_id +'/current?month=0'+this.month).subscribe(r=>{
      this.doctor = r;
      this.calendar = r['calendar'];
      this.month = r['month'];
      this.month_name = r['text'];
    })
    } else {
      this.month --;
      this.http.get('http://192.168.1.134:8000/api/patient/1/doctor/'+ this.doc_id +'/current?month=0'+this.month).subscribe(r=>{
      this.doctor = r;
      this.calendar = r['calendar'];
      this.month = r['month'];
      this.month_name = r['text'];
    })
    }
    this.addNoDays(this.calendar[0].text);
  }
  addNoDays(fDay){
    switch(fDay){
      case "Tuesday":
        this.no_days=[1];
        break;
      case "Wednesday":
        this.no_days=[1,2];
        break;
      case "Thursday":
        this.no_days=[1,2,3];
        break;
      case "Friday":
        this.no_days=[1,2,3,4];
        break;
      case "Saturday":
        this.no_days=[1,2,3,4,5];
        break;
      case "Saturday":
        this.no_days=[1,2,3,4,5,6];
        break;
      default:
        // code block
    }
  }

}
