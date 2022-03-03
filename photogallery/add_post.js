document.addEventListener("DOMContentLoaded", function () {

    let vrem = document.getElementById("add_post_form");
    // console.log(vrem);
    vrem.addEventListener("submit", function (e) {
        e.preventDefault();

        // console.log("Погнали");

        let add_post_Form = new FormData(e.target);

        // console.log(registerForm);
        // console.log("зашел");

        // let url=e.target.href;
        // console.log(url);
        fetch('/handler.php', {
            method: 'POST',
            body: add_post_Form
        }
        )
            .then(response => response.json())
            .then((result) => {
                if (result.errors) {
                    //console.log(result.errors);
                    let dobavl;
                    let proverka;
                    //console.log(result.errors["povtor_email"][0]);
                    if (result.errors["name"] == null) {
                        proverka = document.getElementById("error_name");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("name_photo");
                        proverka = document.getElementById("error_name");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_name">Несоответсвие шаблону "Название"</p>');
                        }
                    }

                    if (result.errors["description"] == null) {
                        proverka = document.getElementById("error_description");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("description_photo");
                        proverka = document.getElementById("error_description");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_description">Несоответсвие шаблону "Описание"</p>');
                        }
                    }

                    if (result.errors["extension"] == null) {
                        proverka = document.getElementById("error_extension");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("add_photo");
                        proverka = document.getElementById("error_extension");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_extension">Несоответсвие типу jpg</p>');
                        }
                    }

                    if (result.errors["filename"] == null) {
                        proverka = document.getElementById("error_filename");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("add_photo");
                        proverka = document.getElementById("error_filename");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_filename">Ошибка в имени файла</p>');
                        }
                    }

                    if (result.errors["type"] == null) {
                        proverka = document.getElementById("error_type");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("add_photo");
                        proverka = document.getElementById("error_type");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_type">Несоответсвие типу jpg</p>');
                        }
                    }

                    if (result.errors["size"] == null) {
                        proverka = document.getElementById("error_size");
                        if (proverka != null) {
                            proverka.remove();
                        }
                    } else {
                        dobavl = document.getElementById("add_photo");
                        proverka = document.getElementById("error_size");
                        if (proverka == null) {
                            dobavl.insertAdjacentHTML('afterend', '<p class="error" id="error_size">Слишком большой файл</p>');
                        }
                    }
                    //вывод ошибок валидации на форму
                } else {
                    console.log("Страница изменена");
                    document.location.replace(result.url);
                    //document.location.reload();
                    //успешно добавили пост, перейдем на деатльную страницу
                }
            })
            .catch(error => console.log(error));

    })


})