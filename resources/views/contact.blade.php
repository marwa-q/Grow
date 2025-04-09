@extends('layouts.app')
@section('title', 'Contact us')

    @section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    border: none;
    outline: none;
    list-style-type: none;
    scroll-behavior: smooth;
    font-family: 'Open Sans', sans-serif;
}

html {
    overflow-x: hidden;
}

:root {
    --orange: #F4A261;
    --danger-red: #DC3545;
    --dark-grey: #333333;
    --black: #000000;
    --white: #FFFFFF;
    --soft-grey: #F5F5F5;
}
  
  /* Hero Section */
  #contact-hero {
    background-image: url(/app/views/LandingPage/img/contact.jpg);
    height: 50vh;
    background-size: cover;
    background-position: center;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
  }

  #contact-hero p {
    margin-top: 10px;
  }
  
  /* Contact Form Section */
  
  
  #contact-form {
    padding: 50px 20px;
    text-align: center;
  }
  
  #contact-form h2 {
    color: #2ebf91;
    margin-bottom: 20px;
  }
  
  #contact-form p {
    color: var(--dark-grey);
    max-width: 800px;
    margin: 0 auto 30px auto;
  }
  
  
  #form-box{
    width: 50%;
    margin: auto;
  }
  
  .form-group {
    margin-bottom: 20px;
    text-align: left;
  }
  
  .form-group label {
    font-size: 1.1rem;
    font-weight: bold;
    display: block;
  }
  
  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }
  
  .form-group textarea {
    resize: vertical;
  }
  
  .cta-button {
    background-color: #2ebf91;
    color: white;
    padding: 15px 30px;
    font-size: 1.2rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .cta-button:hover {
    background-color:rgb(66, 207, 162);
  }
  
  /* Media Queries for Responsiveness */
  @media (max-width: 768px) {

    .hero-content 
  
    #contact-hero p {
      width: 90%;
      text-align: center;
    }
  
    #contact-form {
      padding: 30px 20px;
    }
  
    #form-box {
        width: auto;
    }
  }
    </style>
</head>

<body>

    <!-- Contact Form Section -->
    <section id="contact-form">
        <div id="form-box">
            <h2 class=" mt-5"><strong>Get in Touch</strong></h2>
            <p>If you have any questions, suggestions, or need support, please don't hesitate to contact us. We'll get back to you as soon as possible!</p>

            <form id="form" action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="f7f8861f-d9d8-4099-a41b-86e33b39bc2b">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" required placeholder="Enter subject">
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Write your message here"></textarea>
                </div>

                <button type="submit" class="cta-button">Send Message</button>
            </form>
        </div>
    </section>


    <script>
        window.onload = function() {
            document.getElementById("form").reset(); // Clear fields on load
        };
    </script>
        @include('layouts.footer')

    @endsection

