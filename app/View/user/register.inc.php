
<div class="text-center" style="padding-left: 20px;padding-right: 20px">
    <button type="button" class="btn btn-success btn-block" onclick="civicLogin();">Login Civic</button>
</div>
<ul class="nav nav-pills nav-pills-icons" role="tablist">
    <!--
    color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
    -->
    <li class="nav-item" style=" width: 48%;">
        <a class="nav-link btn btn-white active" href="#div_form_register" role="tab" data-toggle="tab" aria-selected="true">
            Register 
        </a>
    </li>
    <li class="nav-item" style=" width: 48%;">
        <a class="nav-link  show btn  btn btn-white" href="#div_form_login" role="tab" data-toggle="tab" aria-selected="false">
            Login
        </a>
    </li>
</ul>
<div class="tab-content tab-space">

    <div class="tab-pane  active show" id="div_form_register">
        <h1 class="card-title text-center h3">Register</h1> 
        <div class="card-body">
            <form class="form" method="POST" data-func-success="formRegister" action="<?= siteUrl('/user/register/save/') ?>" onsubmit="return formAjax(this)">
                <div class="alert alert-success  form_msg" style="display: none">
                    <div class="alert-icon">
                        <i class="material-icons">check</i>
                    </div>
                    <span class="msg" ></span>
                </div>
                <a class=" fazer-login btn-block btn  btn btn-primary" style="display:none" href="#div_form_login" role="tab" data-toggle="tab" aria-selected="false">  Fazer Login </a>
                <div class="form_register_body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">language</i>
                                </span>
                            </div>
                            <label for="user_country"></label>
                            <select class="form-control" name="country" id="user_country" required="required">
                                <option selected="" disabled>Country</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">face</i>
                                </span>
                            </div>
                            <input type="text" name="name"  class="form-control" placeholder="Name" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">mail_outline</i>
                                </span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                            </div>
                            <input type="password" name="password" placeholder="Password" class="form-control" required="required"/>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-round">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="tab-pane" id="div_form_login">
        <h1 class="card-title text-center h3">Login</h1> 
        <div class="card-body">
            <form class="form" data-func-success="formLogin" action="<?= siteUrl('/user/auth/') ?>" onsubmit="return formAjax(this)">
                <div class="alert alert-success  form_msg" style="display: none">
                    <div class="msg" ></div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">mail_outline</i>
                            </span>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                            </span>
                        </div>
                        <input type="password" name="password" placeholder="Password" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-round">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $.getJSON(siteUrl('/country/list/'), function (data) {
        var html = '<option value="" disabled selected>Country</option>';

        for (var i in data) {
            var row = data[i];

            var selected = '';
            if (user_country === row.code) {
                selected = "selected";
            }
            html += '<option value="' + row.id + '" ' + selected + '>' + row.name + '</option>';
        }
        $("#user_country").html(html);
    });

    function formRegister(form, res) {
        form.find('.form_register_body').slideUp();
        var divMsg = form.find('.form_msg');

        divMsg.removeClass('alert-success');
        divMsg.removeClass('alert-danger');
        if (res.success) {
            divMsg.addClass('alert-success');
            form.find('.fazer-login').show();
        } else {
            divMsg.addClass('alert-danger');
        }
        divMsg.find('.msg').text(res.msg);
        divMsg.slideDown();
    }

    function formLogin(form, res) {
        form.find('input[type="password"]').val('');
        var icon = ' <div class="alert-icon"><i class="material-icons">check</i></div>';
        var divMsg = form.find('.form_msg');
        divMsg.hide();
        divMsg.removeClass('alert-success');
        divMsg.removeClass('alert-danger');
        if (res.success) {
            divMsg.addClass('alert-success');
            location.reload();
        } else {
            icon = '<div class="alert-icon"><i class="material-icons">error_outline</i></div> ';
            divMsg.addClass('alert-danger');
        }
        divMsg.find('.msg').html(icon + ' ' + res.msg);
        divMsg.slideDown();
    }
<?php if (isset($_GET['login'])) { ?>
        $(document).ready(function () {
            $('a[href="#div_form_login"]').click();
        });
<?php } ?>
</script>