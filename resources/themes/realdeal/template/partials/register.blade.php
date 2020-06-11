<!-- SIGNUP MODAL
================================================== -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tạo mới tài khoản</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="body-signup__form">

                            <!-- Sign In form -->
                            <div class="profile__sign-up">

                                <form class="signup__form" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="sr-only">Nhập họ và tên</label>
                                        <input id="register_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nhập họ và tên">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">Nhập tên tài khoản</label>
                                        <input id="register_username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Nhập tên tài khoản">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">Nhập địa chỉ email</label>
                                        <input id="register_email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Nhập địa chỉ email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">Nhập địa chỉ email</label>
                                        <input id="register_phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="sr-only">Mật khẩu</label>
                                                <input id="register_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nhập mật khẩu">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="sr-only">Xác nhận mật khẩu</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
                                                       placeholder="Xác nhận mật khẩu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Tôi đồng ý với <a href="#">Điều khoản</a> and <a
                                                href="#">Quy định sử dụng</a>
                                        </label>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-block btn-accent">
                                        Gửi
                                    </button>
                                </form>

                                <hr>

                                <p>
                                    Bạn đã đăng ký? <a href="#signinModal">Đăng nhập ngay</a>
                                </p>

                            </div> <!-- / .profile__sign-up -->
                        </div> <!-- / .body-signup__form -->
                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
