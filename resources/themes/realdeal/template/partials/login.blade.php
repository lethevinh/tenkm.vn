<!-- SIGNIN MODAL
================================================== -->
<div class="modal fade" id="signinModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Đăng nhập</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="body-signin__form">
                            <!-- Sign In form -->
                            <form class="signin__form" method="POST" action="{{ route('login') }}">
                                @error('error')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                <br><br>
                                @enderror
                            @csrf
                            <!-- Email -->
                                <div class="form-group">
                                    <label for="sign-in__email" class="sr-only">Nhập địa chỉ email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion-android-person"></i></span>
                                        <input placeholder="Nhập địa chỉ email" id="username" type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username" value="{{ old('username') }}" required
                                               autocomplete="username" autofocus>
                                        <span class="invalid-feedback error__username"  role="alert">
                                            @error('username')
                                                <strong>{{ $message }}</strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="sign-in__password" class="sr-only">Nhập mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion-locked"></i></span>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password"
                                               placeholder="Nhập mật khẩu">
                                        <span class="invalid-feedback error__password"  role="alert">
                                            @error('password')
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        {{ __('admin.remember_me') }}
                                    </label>
                                </div>
                                <button class="btn btn-accent btn-block btn-login">Gửi</button>
                            </form>

                            <div class="signin__alt">
                                <p>hoặc đăng nhập bằng tài khoản mạng xã hội</p>
                                <ul class="signin__social">
                                    <li class="facebook"><a href="{{ route('social.login.redirect','facebook') }}"><i class="ion-social-facebook"></i></a></li>
                                    <li class="googleplus"><a href="{{ route('social.login.redirect','google') }}"><i class="ion-social-googleplus"></i></a></li>
                                    <li class="linkedin"><a href="{{ route('social.login.redirect','linkedin') }}"><i class="ion-social-linkedin"></i></a></li>
                                </ul>
                            </div>

                            <!-- Sign Up link -->
                            <hr>
                            <p>Bạn chưa đăng ký? <a href="#signupModal">Tạo tài khoản.</a></p>

                            <!-- Lost password form -->
                            <p>
                                Quên mật khẩu? <a href="#lost-password__form" data-toggle="collapse"
                                                  aria-expanded="false" aria-controls="lost-password__form">
                                    Nhấp vào đây để nhận mật khẩu mới.</a>
                            </p>
                            <div class="collapse" id="lost-password__form">
                                <p class="text-muted">
                                    Nhập địa chỉ email của bạn dưới đây và hệ thống sẽ gửi cho bạn đường dẫn để đặt lại
                                    mật khẩu mới cho bạn.
                                </p>
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label class="sr-only" for="lost-password__email">Nhập địa chỉ email</label>
                                        <input type="email" class="form-control" id="lost-password__email"
                                               placeholder="Nhập địa chỉ email">
                                    </div>
                                    <button type="submit" class="btn btn-accent">Gửi</button>
                                </form>
                            </div> <!-- lost-password__form -->
                        </div> <!-- / .body-signin__form -->
                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
