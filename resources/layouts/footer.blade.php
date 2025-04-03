<footer class="footer bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <!-- القسم الأول: روابط سريعة -->
            <div class="col-md-4">
                <h5>روابط مهمة</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}" class="text-light">من نحن</a></li>
                    <li><a href="{{ route('contact') }}" class="text-light">اتصل بنا</a></li>
                    <li><a href="{{ route('services') }}" class="text-light">خدماتنا</a></li>
                </ul>
            </div>

            <!-- القسم الثاني: التواصل الاجتماعي -->
            <div class="col-md-4 text-center">
                <h5>تابعونا على</h5>
                <a href="#" class="text-light mx-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-light mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-light mx-2"><i class="fab fa-instagram"></i></a>
            </div>

            <!-- القسم الثالث: الاشتراك بالبريد الإلكتروني -->
            <div class="col-md-4">
                <h5>اشترك في النشرة البريدية</h5>
                <form action="{{ route('subscribe') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
                        <button type="submit" class="btn btn-success">اشتراك</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-3">

        <!-- الحقوق -->
        <div class="text-center">
            <p>جميع الحقوق محفوظة © {{ date('Y') }} - موقعنا التطوعي</p>
        </div>
    </div>
</footer>
