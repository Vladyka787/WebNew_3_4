document.addEventListener("DOMContentLoaded", function () {

    let vrem = document.getElementById("form_vhod");

    vrem.addEventListener("submit", function (e) {
        e.preventDefault();

        let vhodForm = new FormData(e.target);

        fetch('/vhod.php', {
            method: 'POST',
            body: vhodForm
        }
        )
            .then(response => response.json())
            .then(result => {
                if (result.errors) {

                    //console.log(result.errors);
                    let dobavl;
                    let proverka;
                    //console.log(result.errors["povtor_email"][0]);
                    if (result.errors["vhod_email"] == null) {
                        proverka = document.getElementById("error_vhod_email");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("vhod_email");
                        proverka = document.getElementById("error_vhod_email");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_vhod_email">Несоответсвие шаблону "Имейл"</p>');
                        }
                    }

                    if (result.errors["vhod_pass"] == null) {
                        proverka = document.getElementById("error_vhod_pass");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("vhod_pass");
                        proverka = document.getElementById("error_vhod_pass");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_vhod_pass">Несоответсвие шаблону "Пароль"</p>');
                        }
                    }

                    if (result.errors["vhod_aut"] == null) {
                        proverka = document.getElementById("error_vhod_aut");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("vhod_pass");
                        proverka = document.getElementById("error_vhod_aut");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_vhod_aut">Неверные Логин или Пароль</p>');
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