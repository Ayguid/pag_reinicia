
var form = document.getElementById('contactForm');
form.addEventListener('submit', function(ev) {
  ev.preventDefault();

modal = document.getElementById('modal');

  modal.style.display = "block";
  var oData = new FormData(form);


  oData.append("CustomField", "This is some extra data");

  var oReq = new XMLHttpRequest();
  oReq.open("POST", "./assets/php/form-process.php", true);
  oReq.onload = function() {
    if (oReq.status == 200) {
      form.reset();
      modal.style.display = "none";
      alert(oReq.response);
      console.log(oReq.response);
    } else {
      modal.style.display = "none";
      alert(oReq.response);
      console.log(oReq.response);
    }
  };

  oReq.send(oData);


}, false);
