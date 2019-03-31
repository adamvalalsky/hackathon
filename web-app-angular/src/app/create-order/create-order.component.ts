import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-create-order',
  templateUrl: './create-order.component.html',
  styleUrls: ['./create-order.component.less']
})
export class CreateOrderComponent implements OnInit {

  constructor(private route: ActivatedRoute, private http:HttpClient) { }

  apiUrl = '';
  form = {};
  date:any;
  doc_id:any;
  term:any;

  ngOnInit() {

    this.doc_id = this.route.params['_value'].doc_id;
    this.date = this.route.params['_value'].date;
    this.term = this.route.params['_value'].term;

    // console.log(this.route.params['_value']);
    
    // http://192.168.1.134:8000/api/patient/1/doctor/1/order post request

    this.apiUrl = 'http://192.168.1.134:8000/api/patient/1/doctor/'+this.doc_id+'/form?date='+this.date+'&term='+this.term;

    this.http.get(this.apiUrl).subscribe(r=>{
      this.form = r;
      console.log(this.form)
    })

  }

}
