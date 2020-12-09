<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <title>Make payment with Paystack</title>
</head>
<body>

  <div class="container">
    <div class="row mt-5">
      <div class="col-md-4">
        <div class="card" style="width: 18rem;">
          <img src="./img/iphone.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Iphone 12</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">$80000</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Paystack Payment Integration</h3>
          </div>
          <div class="card-body">
            <form id="paymentForm">
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email-address" required />
              </div>
              <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control" id="first-name" />
              </div>
              <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control" id="last-name" />
              </div>
              <div class="form-submit">
                <button type="submit" class="btn btn-success" onclick="payWithPaystack()"> Pay </button>
              </div>
            </form>
            <script src="https://js.paystack.co/v1/inline.js"></script> 
          </div>
        </div>
      </div>
    </div>
  </div>
  
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
  const paymentForm = document.getElementById('paymentForm');
  paymentForm.addEventListener("submit", payWithPaystack, false);
  function payWithPaystack(e) {
    e.preventDefault();
    let handler = PaystackPop.setup({
      key: 'pk_test_5faa3108400fbc2d327fffee664a692f1cda371a', // Replace with your public key
      currency: 'GHS',
      email: document.getElementById("email-address").value,
      amount: 80000 * 100,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      // label: "Optional string that replaces customer email"
      onClose: function(){
        window.location = "http://localhost/codes/tut/paystack/index.php?transaction=call";
        alert('Transaction Cancelled');
      },
      callback: function(response){
        let message = 'Payment complete! Reference: ' + response.reference;
        alert(message);
        window.location = "http://localhost/codes/tut/paystack/verify_transaction.php?reference=" + response.reference;
      }
    });
    handler.openIframe();
  }
</script>
</body>
</html>