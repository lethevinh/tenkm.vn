
<!-- section footer -->
<footer class="section__footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-4">
                <div class="footer_title__body">
                    <h2 class="footer__title">
                        EDUREAL<span>.</span>
                    </h2>
                    <div class="footer__subtitle">
                        THE ACADEMY OF EXPERTS
                    </div>
                    <ul class="footer__social">
                        <li><a href="{{option('linkedin')}}"><i class="ion-social-linkedin"></i></a></li>
                        <li><a href="{{option('facebook')}}"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="{{option('youtube')}}"><i class="ion-social-youtube"></i></a></li>
                    </ul>
                </div> <!-- / .footer_title__body -->
            </div>
            <div class="col-md-3 col-sm-4">
                <x-menu name="privacy"></x-menu>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="newsletter__body">
                    <p class="newsletter__subtitle">Subscribe to our newsletter to get news.</p>
                    <!-- Newsletter form -->
                    <form class="footer__form">
                        <div class="form-group">
                            <label for="footer_newsletter__email" class="sr-only">E-mail address</label>
                            <input type="email" class="form-control" id="footer_newsletter__email" placeholder="Your email">
                        </div>
                        <a href="#" class="btn btn-newsletter"><i class="ion-android-arrow-forward"></i></a>
                    </form> <!-- .newsletter__form -->
                </div> <!-- / .newsletter__body -->
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</footer> <!-- .section__footer -->

<!-- section footer copyright -->
<div class="footer__copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-6 col-md-push-6">
                <x-menu name="footer"></x-menu>
            </div>
            <div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-6 col-md-pull-6">
                <div class="copyright__content">
                    <p>&#169; Edureal. {{date('Y')}} All rights reserved.</p>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .footer__copyright -->
