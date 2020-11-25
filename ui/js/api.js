 class Api { 
  constructor() {
    this.production = true;
    if(this.production){
      this.api = "https://mentorshipapptest.herokuapp.com/api/"; //production api
    }else{
      this.api = "http://127.0.0.1:5000/api/"; //dev api
    }
  }
  getDatabaseSetupEndPoint() {
      return this.api+"config/database_setup.php";
  }

  getMentorSignupEndpoint() {
    return this.api+"mentor_signup.php";
  }

  getMenteeSignupEndpoint() {
    return this.api+"mentee_signup.php";
  }

  getMentorProfileEndpoint(id) {
    return this.api+"mentor_profile.php?id="+id;
  }

  getMenteeProfileEndpoint(id) {
  return this.api+"mentee_profile.php?id="+id;
  }

  getMentorsOfMenteeEndpoint(id) {
    return this.api+"mentor_of_mentee.php?mentee_id="+id;
    }
  
    async signUp(url, myForm){
      let formdata = new FormData(myForm);
      let request = new Request(url, { method: "POST",
                                       body: formdata });
      return await fetch(request);
    }
}




document.addEventListener('DOMContentLoaded', function() {
  
  let x = new Api();
console.log(x.getMentorSignupEndpoint())

const signUpForm = document.querySelector('#signUpForm')

signUpForm.addEventListener('submit', async(e) => {
  e.preventDefault()
  // await signUp(url, myForm);
  let inputData = JSON.stringify(Object.fromEntries(new FormData(event.target)));
  console.log(delete inputData['password-repeat']);
  console.log(JSON.parse(inputData));
  let submittable = {
                    'name': JSON.parse(inputData).name,
                    'email': JSON.parse(inputData).email,
                    'password': JSON.parse(inputData).password
                  }
  console.log(submittable);

  let signUpUrl = null;
  if(JSON.parse(inputData).category == 'mentor'){
     signUpUrl = x.getMentorSignupEndpoint();
  }else{
     signUpUrl = x.getMenteeSignupEndpoint();
  }

    fetch(signUpUrl, {
      method: 'POST',
      body: inputData,
      headers: {
        'Content-type': 'application/json; charset=UTF-8'
      }
    }).then(function (response) {
      if (response.ok) {
        return response.json();
      }
      // console.log(response.status)
      return Promise.reject(response);
    }).then(function (data) {
      console.log(data);
      // // console.log(data.status)

    }).catch(function (error) {
      console.warn(error);
      // console.log(error.status)

    });
  
})



})