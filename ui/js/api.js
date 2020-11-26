 class Api { 
  constructor() {
    this.production = false;
    if(this.production){
      this.api = "https://secure-reef-39872.herokuapp.com/api/"; //production api
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

}

document.addEventListener('DOMContentLoaded', function() {

let x = new Api();
const signUpForm = document.querySelector('#signUpForm'),
       signUpButton = document.querySelector('#signUpButton'),
       loginButton = document.querySelector('#loginButton'),
       logoutButton = document.querySelector('#logoutButton');

let signUpSection = document.getElementById('signUpSection'),
     profileSection = document.getElementById('profileSection'),
     loginSection = document.getElementById('loginSection'),

     userCategory = document.getElementById('userCategory'),
     profile_fullname = document.getElementById('profile_fullname'),
     profile_email = document.getElementById('profile_email'),
     profile_created_on = document.getElementById('profile_created_on'),
     listOfMentor = document.getElementById('listOfMentor'),
     menteesMentor = document.getElementById('menteesMentor'),
    password = document.getElementById("password"),
    confirm_password = document.getElementById("password-repeat");

if(sessionStorage.getItem("Token") !== null){
  signUpSection.style.display = "none";
  profileSection.style.display = "block";
  loginSection.style.display = "none"

  //ste profile details
  userCategory.innerText = sessionStorage.getItem("Category");
  profile_fullname.innerText  = sessionStorage.getItem("Name");
  profile_email.innerText  = sessionStorage.getItem("Email");
  profile_created_on.innerText  = sessionStorage.getItem("Created");

  //check if user is mentor
  if(sessionStorage.getItem("Category") == 'mentor'){
    listOfMentor.style.display = "none";
    }
  else if(sessionStorage.getItem("Category") == 'mentee'){
      // listOfMentor.style.display = "block";
      menteesMentor.innerText = sessionStorage.getItem("Mentor");
    }
}else{
  signUpSection.style.display = "block";
  profileSection.style.display = "none";
  loginSection.style.display = "none"
}

logoutButton.addEventListener('click', () => {
    sessionStorage.clear();
    signUpSection.style.display = "block";
    profileSection.style.display = "none";
    loginSection.style.display = "none";
})

loginButton.addEventListener('click', () => {
  if(sessionStorage.getItem("Token") == true){
    signUpSection.style.display = "none";
    profileSection.style.display = "block";
    loginSection.style.display = "none";
  }else{
    signUpSection.style.display = "none";
    profileSection.style.display = "none";
    loginSection.style.display = "block";
  } 
})

signUpButton.addEventListener('click', () => {
  if(sessionStorage.getItem("Token") == true){
    signUpSection.style.display = "none";
    profileSection.style.display = "block";
    loginSection.style.display = "none";
  }else{
    signUpSection.style.display = "block";
    profileSection.style.display = "none";
    loginSection.style.display = "none";
  } 
})



//signup for mentor and mentee
signUpForm.addEventListener('submit', (e) => {
  e.preventDefault()
  if(password.value != confirm_password.value) {
    alert("Password not match");
    return null;
  }
  let inputData = JSON.stringify(Object.fromEntries(new FormData(event.target)));
  
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
      return Promise.reject(response);
    }).then(function (data) {
      if(data.status != 422){
          signUpSection.style.display = "none";
          profileSection.style.display = "block";
          loginSection.style.display = "none"
        //set session variable 
          sessionStorage.setItem("Token", data.token);
          sessionStorage.setItem("Name", data.profile.name);
          sessionStorage.setItem("Email", data.profile.email);
          sessionStorage.setItem("Created", data.profile.created);
          sessionStorage.setItem("Category", data.category);

          userCategory.innerText = data.category;
          profile_fullname.innerText  = data.profile.name;
          profile_email.innerText  = data.profile.email;
          profile_created_on.innerText  = data.profile.created;
          if(data.category == 'mentor'){
            listOfMentor.style.display = "none";
          }else{
          // sessionStorage.setItem("User", 'mentee');
          sessionStorage.setItem("Mentee_id", data.profile.mentee_id);
          
          for (let index = 0; index < data.mentors.length; index++) {
            if(menteesMentor.innerText !== "None"){
              menteesMentor.innerText = menteesMentor.innerText + ', '+ data.mentors[index].mentor_name ;
            }else{
              menteesMentor.innerText = data.mentors[index].mentor_name; 
            }       
          }
          sessionStorage.setItem("Mentor", menteesMentor.innerText);
        }
        alert(data.message);
      }else{
        // (data.error)
    sessionStorage.clear();

        alert(data.error);
      }
    }).catch(function (error)  {
      alert(error);
    }); 

});

//login for mentor and mentee
loginForm.addEventListener('submit', (e) => {
  e.preventDefault()
  alert("Not Implemented");
});





})