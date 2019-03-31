import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-free-termin',
  templateUrl: './free-termin.component.html',
  styleUrls: ['./free-termin.component.less']
})
export class FreeTerminComponent implements OnInit {

  apiUrl:string;
  date = {};
  terms = [];
  doc_id:any;
  month:any;
  day:any;

  constructor(private http:HttpClient, private route: ActivatedRoute, private router:Router) { }

  ngOnInit() {

    this.doc_id = this.route.params['_value'].doc_id;
    this.month = this.route.params['_value'].month;
    this.day = this.route.params['_value'].day;

    this.apiUrl = 'http://192.168.1.134:8000/api/patient/1/doctor/'+this.doc_id+'/step_one?month='+this.month+'&day='+this.day;

    this.http.get(this.apiUrl).subscribe(r=>{
      this.date = r;
      this.terms.push(r['terms'])
    })
  }

  getStyle(available){
    if (available) {
      return 'free cursor';
    } else {
      return 'reserved';
    }
  }

  redirectForward(available, term){
    if (available) {
      var helper = this.doc_id+'/form?date='+this.date+'&term='+term;
      this.router.navigate(['/create-order/'+this.doc_id+'/date/'+this.date['date']+'/term/'+term])
    }
  }

}
