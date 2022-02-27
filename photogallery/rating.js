document.addEventListener("DOMContentLoaded", function () {

    let vrem = document.getElementById("body__container__right__button");

    if (!!vrem) {
        vrem.addEventListener("click", function (e) {
            e.preventDefault();

            let select = document.getElementById("body__container__right__select");

            let index = select.options.selectedIndex;

            //console.log(select.options[index].text);

            let url = "/rating.php/?rate=" + select.options[index].text + "&id=" + select.options[index].value;

            fetch(url)
                .then(response => response.text())
                .then((result) => {
                    if (result == "success") {
                        console.log("Успех");
                        document.location.reload();
                    }
                })
                .catch(error => console.log(error));
        })
    }
})