
    //   copy your firebase config informations
    const firebaseConfig = {
        apiKey: "AIzaSyAkGpz1mfez9fIIVM1GWOdTxtqNjZuO3-4",
        authDomain: "contactform-3e060.firebaseapp.com",
        databaseURL: "https://contactform-3e060-default-rtdb.firebaseio.com",
        projectId: "contactform-3e060",
        storageBucket: "contactform-3e060.appspot.com",
        messagingSenderId: "515933455161",
        appId: "1:515933455161:web:6a08de6d225703954b1ee8"

  };
  
  // initialize firebase
  firebase.initializeApp(firebaseConfig);
  
  // reference your database
  var contactFormDB = firebase.database().ref("contactForm");
  
  document.getElementById("contactForm").addEventListener("submit", submitForm);
  
  function submitForm(e) {
    e.preventDefault();
  
    var name = getElementVal("name");
    var emailid = getElementVal("emailid");
    var msgContent = getElementVal("msgContent");
  
    saveMessages(name, emailid, msgContent);
  
    //   enable alert
    document.querySelector(".alert").style.display = "block";
  
    //   remove the alert
    setTimeout(() => {
      document.querySelector(".alert").style.display = "none";
    }, 3000);
  
    //   reset the form
    document.getElementById("contactForm").reset();
  }
  
  const saveMessages = (name, emailid, msgContent) => {
    var newContactForm = contactFormDB.push();
  
    newContactForm.set({
      name: name,
      emailid: emailid,
      msgContent: msgContent,
    });
  };
  
  const getElementVal = (id) => {
    return document.getElementById(id).value;
  };
  