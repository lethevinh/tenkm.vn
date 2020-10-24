console.log(' User init');
const keyToken = '__token';
const keyUser = '__user';
$(document).ready(() => {
// Login
    $(document).on('click', '.btn-logout', async function (event) {
        if (window.edureal.isLoggedin || window.checkLogin()) {
            event.stopPropagation();
            event.preventDefault();
            await axios.get('/api/logout');
            await localStorage.removeItem(keyToken);
            await localStorage.removeItem(keyUser);
            await renderProfileBar();
            location.reload();
        }
    });
    if (window.edureal.isLoggedin) {
        $('.editable_field').each((index, field) => {
            let fieldEl = $(field);
            let fieldName = fieldEl.attr('data-field-name');
            let fieldLabel = fieldEl.attr('data-field-label');
            let type = 'text';
            if(fieldEl.attr('data-field-type')) {
                type = fieldEl.attr('data-field-type');
            }
            fieldEl.editable({
                type: type,
                name: fieldName,
                pk: 1,
                url: '/profile-edit-inline/' + window.edureal.user.username,
                title: trans('theme.enter') + ' ' + fieldLabel
            });
        });
        // Update Avatar
        $('.image_editor').append('<button class="btn btn-primary btn-sm "><i class="ion-camera"></i> Cập Nhật</button><input type="file" accept="image/*" class="file-input" />');
        $(document).on("click",".image_editor button",function() {
            $('.image_editor input.file-input').trigger('click');
        });
        $('.image_editor input.file-input').change(function (e) {
            let files = e.target.files;
            if (files.length < 1) {
                return;
            }
            let file = files[0];
            let data = new FormData();
            let settings = { headers: { 'content-type': 'multipart/form-data' } };
            data.append('avatar', file, file.name);
            axios.post('/profile-edit-avatar/' + window.edureal.user.username, data, settings)
                .then(response => {
                    if (response.status < 400 && response.data.data) {
                        let image = $('.image_editor img');
                        image.src = response.data.data.avatar;
                        image.prop('src', response.data.data.avatar);
                    }
                }).catch(response => {console.log(response)});
        });
        // Comment
        $('.comment__reply .comment__btn').click(function () {
          let form = $(this).next();
          form.show();
        });
    }
// Login
    $('.signin__form button.btn-login').click(async function (event) {
        event.stopPropagation();
        event.preventDefault();
        let form = $(this).parent('form.signin__form');
        let data = form.serializeArray().reduce((obj, item) => {
            return {
                ...obj,
                [item.name]: item.value,
            };
        }, {})
        form.find('.invalid-feedback').html('');
        if (data.username.length === 0) {
            let errorEl = form.find('.error__username');
            errorEl.append(`<strong>The username field is required. </strong>`);
            return;
        }
        if (data.password.length === 0) {
            let errorEl = form.find('.error__password');
            errorEl.append(`<strong>The password field is required. </strong>`);
            return;
        }
        let response = await axios.post('/api/login', data);
        if (response.data.success && response.data.data) {
            await localStorage.setItem(keyToken, response.data.data.token);
            await localStorage.setItem(keyUser, JSON.stringify(response.data.data.user));
            await renderProfileBar();
            location.reload();
        } else if (response.data.error && response.data.data) {
            let errors = response.data.data.error;
            let keys = Object.keys(errors);
            keys.forEach(function (key, index) {
                let error = errors[key];
                let errorEl = form.find('.error__' + key);
                errorEl.html('');
                if (errorEl.length > 0) {
                    error.forEach(function (item) {
                        errorEl.append(`<strong>${item} </strong>`);
                    })
                }
            })
        }
    });

// Render User
    async function getLocalUser() {
        let user = await localStorage.getItem(keyUser);
        return JSON.parse(user);
    }

    async function renderProfileBar() {
        let profileBarEl = $('.nav__profile_bar');
        if (profileBarEl.length > 0 && window.edureal.isLoggedin) {
            let user = await getLocalUser();
            if (user) {
                profileBarEl.html(`<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="ion-android-person"></i> ${user.name} <i class="ion-android-arrow-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/profile-edit/${user.username}" class="dropdown-item">
                                   ${trans('admin.profile')}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item btn-logout">
                                   ${trans('admin.logout')}
                                </a>
                            </li>
                        </ul>
                    </li>`);
            } else {
                profileBarEl.html(`<li><a href="#signinModal" data-toggle="modal"><i class="ion-log-in"></i> ${trans('admin.login')} </a></li>
                    <li><a href="#signupModal" data-toggle="modal"><i class="ion-android-person"></i>  ${trans('admin.register')}</a></li>`);
            }
        }
    }
    renderProfileBar().then(r => {
    });
});
