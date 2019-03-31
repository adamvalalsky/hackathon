import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent implements OnInit {

  isSigningIn = true;
  role = 'none';
  constructor(private router: Router) {
    document.body.className = "bg-gradient";
    }

  ngOnDestroy(){
      document.body.className="";
    }

  ngOnInit() {
  }

  toggleLogin(){
    this.isSigningIn = !this.isSigningIn;
    this.role = 'none';

    console.log(this.isSigningIn)
  }

  setRole(role){
    if (role == 'doc') {
      this.role = 'doc';
    } else {
      this.role = 'patient';
    }
  }

  login(){
    this.router.navigate(['/user-dashboard']);
  }

}
