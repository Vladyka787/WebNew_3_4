document.addEventListener("DOMContentLoaded", function () {

    let vrem = document.getElementById("register_form");
    // console.log(vrem);
    vrem.addEventListener("submit", function (e) {
        e.preventDefault();

        // console.log("Погнали");

        let registerForm = new FormData(e.target);

        // console.log(registerForm);
        // console.log("зашел");

        // let url=e.target.href;
        // console.log(url);
        fetch('/registration.php', {
            method: 'POST',
            body: registerForm
        }
        )
            .then(response => response.json())
            .then((result) => {
                if (result.errors) {
                    //console.log(result.errors);
                    let dobavl;
                    let proverka;
                    //console.log(result.errors["povtor_email"][0]);
                    if (result.errors["povtor_email"] == null) {
                        proverka = document.getElementById("error_povtor_reg_email");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_email");
                        proverka = document.getElementById("error_povtor_reg_email");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_povtor_reg_email">Данный имейл уже зарегистрирован</p>');
                        }
                    }

                    if (result.errors["reg_name"] == null) {
                        proverka = document.getElementById("error_reg_name");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_name");
                        proverka = document.getElementById("error_reg_name");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_name">Несоответсвие шаблону "Имя"</p>');
                        }
                    }

                    if (result.errors["reg_email"] == null) {
                        proverka = document.getElementById("error_reg_email");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_email");
                        proverka = document.getElementById("error_reg_email");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_email">Несоответсвие шаблону "Имейл"</p>');
                        }
                    }

                    if (result.errors["reg_telefon"] == null) {
                        proverka = document.getElementById("error_reg_telefon");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_telefon");
                        proverka = document.getElementById("error_reg_telefon");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_telefon">Несоответсвие шаблону "Телефон"</p>');
                        }
                    }

                    if (result.errors["reg_pass_1"] == null) {
                        proverka = document.getElementById("error_reg_pass_1");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_pass_1");
                        proverka = document.getElementById("error_reg_pass_1");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_pass_1">Несоответсвие шаблону "Пароль"</p>');
                        }
                    }

                    if (result.errors["reg_pass_verify"] == null) {
                        proverka = document.getElementById("error_reg_pass_verify");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_pass_2");
                        proverka = document.getElementById("error_reg_pass_verify");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_pass_verify">Пароли не совпадают</p>');
                        }
                    }

                    if (result.errors["reg_usl"] == null) {
                        proverka = document.getElementById("error_reg_usl");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_usl");
                        proverka = document.getElementById("error_reg_usl");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_reg_usl">Примите условия пользовательского соглашения</p>');
                        }
                    }

                    if (result.errors["povtor_telefon"] == null) {
                        proverka = document.getElementById("error_povtor_reg_telefon");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("reg_telefon");
                        proverka = document.getElementById("error_povtor_reg_telefon");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_povtor_reg_telefon">Данный телефон уже зарегистрирован</p>');
                        }
                    }
                    //вывод ошибок валидации на форму
                } else {
                    console.log("Страница обновлена");
                    document.location.reload();
                    //успешная регистрация, обновляем страницу
                }
            })
            .catch(error => console.log(error));

    })


})