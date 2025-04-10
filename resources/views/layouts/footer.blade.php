<link rel="stylesheet" href="{{ asset('css/fotter.css') }}">

<footer class="footer">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <!-- معلومات المؤسسة -->
                <div class="footer-content col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-logo mb-4">
                        <h3 class="text-white fw-bold mb-3">Grow</h3>
                    </div>
                    <p style="width: 100% !important" class="text-light mb-4">Grow is a volunteer-driven platform that connects individuals with meaningful community activities across Jordan. Whether it's tree planting, cleanup campaigns, or local events, users can easily discover, join, and contribute to causes they care about. Grow also enables users to share their experiences through posts, comments, and likes, fostering a vibrant and engaged community of changemakers.</p>
                </div>

                <!-- روابط سريعة -->
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('home')}}"><i class="fas fa-angle-left ms-2"></i>Home</a></li>
                        <li><a href="{{ route('about')}}"><i class="fas fa-angle-left ms-2"></i>About Us</a></li>
                        <li><a href="{{ route('activities.index')}}"><i class="fas fa-angle-left ms-2"></i>Activities</a></li>
                        <li><a href="{{ route('posts.index')}}"><i class="fas fa-angle-left ms-2"></i>Posts</a></li>
                        <li><a href="{{ route('contact')}}"><i class="fas fa-angle-left ms-2"></i>Contact Us</a></li>
                    </ul>
                </div>

               

            <!-- شريط التذييل السفلي -->
            <div class="footer-bottom text-center">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-3">© 2025 Charity Site. All rights reserved</p>
                    </div>
                </div>
                <!-- زر العودة للأعلى -->
                <a href="#" class="back-to-top" aria-label="Back to top"> <i class="fas fa-chevron-up"></i>
                </a>
            </div>
        </div>
    </footer>